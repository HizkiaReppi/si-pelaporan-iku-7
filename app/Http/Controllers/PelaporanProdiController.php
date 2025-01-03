<?php

namespace App\Http\Controllers;

use App\Helpers\IKUHelper;
use App\Helpers\PeriodHelper;
use App\Helpers\StatusHelper;
use App\Models\Course;
use App\Models\IKU7;
use App\Models\Period;
use App\Models\User;
use App\Notifications\ReportUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PelaporanProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Apakah anda yakin?';
        $text = 'Anda tidak akan bisa mengembalikannya!';
        confirmDelete($title, $text);

        if ($request->ajax()) {
            $model = Course::where('period_id', PeriodHelper::getCurrentPeriod())
                ->where('department_id', auth()->user()->department_id)
                ->with(['pelaporanIku', 'periode'])
                ->get();

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('kodeMk', function ($row) {
                    return $row->code;
                })
                ->addColumn('namaMk', function ($row) {
                    return $row->name;
                })
                ->addColumn('periode', function ($row) {
                    return $row->periode->name;
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge text-bg-' . StatusHelper::parseUserBadgeClassNameStatus($row->pelaporanIku->status_verifikasi) . '">' . StatusHelper::parseUserStatus($row->pelaporanIku->status_verifikasi) . '</span>';
                })
                ->addColumn('deskripsi', function ($row) {
                    return $row->pelaporanIku->deskripsi_verifikasi ?? 'Belum ada data';
                })
                ->addColumn('action', function ($row) {
                    if ($row->pelaporanIku->status_verifikasi !== 'draft' && $row->pelaporanIku->status_verifikasi !== 'rejected') {
                        $btn =
                            '<a class="dropdown-item" href="' .
                            route('dashboard.pelaporan-prodi.show', $row->pelaporanIku->id) .
                            '">
                <i class="bx bxs-user-detail me-1"></i> Detail
            </a>';
                    } else {
                        $btn =
                            '<div class="dropdown">
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
            data-bs-toggle="dropdown">
            <i class="bx bx-dots-vertical-rounded"></i>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="' .
                            route('dashboard.pelaporan-prodi.show', $row->pelaporanIku->id) .
                            '">
                <i class="bx bxs-user-detail me-1"></i> Detail
            </a>
            <a href="' .
                            route('dashboard.pelaporan-prodi.edit', $row->pelaporanIku->id) .
                            '" class="dropdown-item btn-edit">
                <i class="bx bx-edit-alt me-1"></i> Edit
                </a>';
                        $btn .= '
                    </div>
                    </div>';
                    }
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.pelaporan-prodi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(IKU7 $pelaporan): View
    {
        $pelaporan->load('mataKuliah');
        return view('dashboard.pelaporan-prodi.show', compact('pelaporan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $periods = Period::all();
        return view('dashboard.pelaporan-prodi.create', compact('periods'));
    }

    public function edit(IKU7 $pelaporan)
    {
        if ($pelaporan->status_verifikasi !== 'draft' && $pelaporan->status_verifikasi !== 'rejected') {
            return redirect()->back()->with('toast_error', 'Data sedang diverifikasi. Silakan menunggu terlebih dahulu.');
        }

        $pelaporan->load('mataKuliah');
        return view('dashboard.pelaporan-prodi.edit', compact('pelaporan'));
    }

    public function update(Request $request, IKU7 $pelaporan)
    {
        $validatedData = Validator::make($request->all(), [
            'bobot_case_method' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_project_based' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_kuis' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uas' => ['required', 'numeric', 'min:0', 'max:100'],
            'deskripsi_penilaian_case_method' => ['nullable', 'string'],
            'deskripsi_penilaian_project_based' => ['nullable', 'string'],
            'deskripsi_penilaian_kognitif_tugas' => ['nullable', 'string'],
            'deskripsi_penilaian_kognitif_kuis' => ['nullable', 'string'],
            'deskripsi_penilaian_kognitif_uts' => ['nullable', 'string'],
            'deskripsi_penilaian_kognitif_uas' => ['nullable', 'string'],
            'file_rps' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ])->after(function ($validator) use ($request) {
            $totalBobot = $request->bobot_case_method + $request->bobot_project_based + $request->bobot_kognitif_tugas + $request->bobot_kognitif_kuis + $request->bobot_kognitif_uts + $request->bobot_kognitif_uas;

            if ($totalBobot > 100) {
                $validator->errors()->add('total_bobot', 'Total bobot tidak boleh lebih dari 100.');
            }

            if ($request->bobot_case_method + $request->bobot_project_based < 50) {
                $validator->errors()->add('bobot_case_method', 'Bobot Case Method dan Project Based harus total minimal 50.');
                $validator->errors()->add('bobot_project_based', 'Bobot Case Method dan Project Based harus total minimal 50.');
            }
        });

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }

        $data = $validatedData->validated();

        DB::beginTransaction();

        try {
            $pelaporan->score_case_method = $data['bobot_case_method'];
            $pelaporan->score_project_based = $data['bobot_project_based'];
            $pelaporan->score_cognitive_task = $data['bobot_kognitif_tugas'];
            $pelaporan->score_cognitive_quiz = $data['bobot_kognitif_kuis'];
            $pelaporan->score_cognitive_uts = $data['bobot_kognitif_uts'];
            $pelaporan->score_cognitive_uas = $data['bobot_kognitif_uas'];

            if (isset($data['deskripsi_penilaian_case_method'])) {
                $pelaporan->description_case_method = $data['deskripsi_penilaian_case_method'];
            }

            if (isset($data['deskripsi_penilaian_project_based'])) {
                $pelaporan->description_project_based = $data['deskripsi_penilaian_project_based'];
            }

            if (isset($data['deskripsi_penilaian_kognitif_tugas'])) {
                $pelaporan->description_cognitive_task = $data['deskripsi_penilaian_kognitif_tugas'];
            }

            if (isset($data['deskripsi_penilaian_kognitif_kuis'])) {
                $pelaporan->description_cognitive_quiz = $data['deskripsi_penilaian_kognitif_kuis'];
            }

            if (isset($data['deskripsi_penilaian_kognitif_uts'])) {
                $pelaporan->description_cognitive_uts = $data['deskripsi_penilaian_kognitif_uts'];
            }

            if (isset($data['deskripsi_penilaian_kognitif_uas'])) {
                $pelaporan->description_cognitive_uas = $data['deskripsi_penilaian_kognitif_uas'];
            }

            if ($pelaporan->file_rps) {
                $filePath = str_replace('/storage', 'public', $pelaporan->file_rps);
                $filePath = storage_path('app/' . $filePath);
                Storage::delete($filePath);
            }

            $file = $request->file('file_rps');
            $formattedCourseName = str_replace(' ', '-', strtolower($pelaporan->mataKuliah->name));
            $fileName = time() . '_' . $pelaporan->mataKuliah->code . '_' . $formattedCourseName . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('public/rps', $fileName);
            $formattedFilePath = str_replace('public', '/storage', $filePath);

            $pelaporan->file_rps = $formattedFilePath;
            $pelaporan->status_verifikasi = 'pending';

            $adminUsers = User::where('role', 'admin')
                ->whereNotIn('email', ['superadmin@gmail.com', 'admin@gmail.com'])
                ->get();

            foreach ($adminUsers as $admin) {
                $admin->notify(new ReportUpdatedNotification($pelaporan));
            }

            $pelaporan->save();

            DB::commit();
            return redirect()->route('dashboard.pelaporan-prodi.index')->with('toast_success', 'Data Bobot dan Deskripsi Kuliah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function view(IKU7 $daftar_pelaporan): View
    {
        $daftar_pelaporan->load('mataKuliah');
        $filePath = str_replace('/storage', 'public', $daftar_pelaporan->file_rps);
        $filePath = storage_path('app/' . $filePath);
        $mimeType = mime_content_type($filePath);

        return view('dashboard.pelaporan-prodi.view', compact('daftar_pelaporan', 'mimeType'));
    }

    public function inputBobot(Course $mata_kuliah)
    {
        $mata_kuliah->load('pelaporanIku');
        return redirect()->route('dashboard.pelaporan-prodi.edit-bobot', $mata_kuliah->pelaporanIku->id);
    }

    public function inputDeskripsi(Course $mata_kuliah)
    {
        $mata_kuliah->load('pelaporanIku');
        return redirect()->route('dashboard.pelaporan-prodi.edit-deskripsi', $mata_kuliah->pelaporanIku->id);
    }
}
