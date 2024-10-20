<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Course;
use App\Models\Department;
use App\Models\IKU7;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
            $model = Course::where('department_id', auth()->user()->department_id)
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
                ->addColumn('action', function ($row) {
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
                        route('dashboard.pelaporan-prodi.edit-bobot', $row->pelaporanIku->id) .
                        '" class="dropdown-item btn-edit">
                                <i class="bx bx-edit-alt me-1"></i> Edit Bobot
                            </a>
                            <a href="' .
                        route('dashboard.pelaporan-prodi.edit-deskripsi', $row->pelaporanIku->id) .
                        '" class="dropdown-item btn-edit">
                                <i class="bx bx-edit-alt me-1"></i> Edit Deskripsi
                            </a>
                            <button class="dropdown-item btn-edit"
                                             data-bs-toggle="modal" data-bs-target="#modal-edit-rps" data-id="' .
                        $row->pelaporanIku->id .
                        '" data-name="' .
                        $row->name .
                        '">
                                            <i class="bx bx-edit-alt me-1"></i> Edit RPS
                                        </button>
                        </div>
                    </div>';
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

    private function token()
    {
        $client_id = \Config('services.google.client_id');
        $client_secret = \Config('services.google.client_secret');
        $refresh_token = \Config('services.google.refresh_token');

        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'refresh_token' => $refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        $accessToken = json_decode((string) $response->getBody(), true)['access_token'];

        return $accessToken;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accessToken = $this->token();
        $folderId = config('services.google_drive.folder_id');

        $validatedData = $request->validate([
            'kode_mk' => ['required', 'string', 'max:10'],
            'nama_mk' => ['required', 'string', 'max:100'],
            'bobot_case_method' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_project_based' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_kuis' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uas' => ['required', 'numeric', 'min:0', 'max:100'],
            'deskripsi_penilaian_case_method' => ['required', 'string'],
            'deskripsi_penilaian_project_based' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_tugas' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_kuis' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_uts' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_uas' => ['required', 'string'],
            'file_rps' => ['required', 'file', 'mimes:pdf', 'max:2048'],
            'periode_id' => ['required', 'exists:' . Period::class . ',id'],
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file_rps');
            $name = $validatedData['kode_mk'] . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->getRealPath();

            $fileMetadata = [
                'name' => $name,
                'parents' => [$folderId],
            ];

            $response = Http::withToken($accessToken)->attach('metadata', json_encode($fileMetadata), 'metadata.json')->attach('file', file_get_contents($path), $name)->post('https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart');

            if ($response->successful()) {
                $file_id = json_decode($response->body())->id;

                $departmentId = Department::where('user_id', auth()->user()->id)->first()->id;

                $course = new Course();
                $course->code = $validatedData['kode_mk'];
                $course->name = $validatedData['nama_mk'];
                $course->department_id = $departmentId;
                $course->save();

                $iku = new IKU7();
                $iku->user_id = auth()->user()->id;
                $iku->course_id = $course->id;
                $iku->period_id = $validatedData['periode_id'];
                $iku->department_id = $departmentId;
                $iku->score_case_method = $validatedData['bobot_case_method'];
                $iku->score_project_based = $validatedData['bobot_project_based'];
                $iku->score_cognitive_task = $validatedData['bobot_kognitif_tugas'];
                $iku->score_cognitive_quiz = $validatedData['bobot_kognitif_kuis'];
                $iku->score_cognitive_uts = $validatedData['bobot_kognitif_uts'];
                $iku->score_cognitive_uas = $validatedData['bobot_kognitif_uas'];
                $iku->description_case_method = $validatedData['deskripsi_penilaian_case_method'];
                $iku->description_project_based = $validatedData['deskripsi_penilaian_project_based'];
                $iku->description_cognitive_task = $validatedData['deskripsi_penilaian_kognitif_tugas'];
                $iku->description_cognitive_quiz = $validatedData['deskripsi_penilaian_kognitif_kuis'];
                $iku->description_cognitive_uts = $validatedData['deskripsi_penilaian_kognitif_uts'];
                $iku->description_cognitive_uas = $validatedData['deskripsi_penilaian_kognitif_uas'];
                $iku->file_rps = $file_id;
                $iku->save();

                DB::commit();
                return redirect()->route('dashboard.pelaporan-prodi.index')->with('toast_success', 'Data Mata Kuliah berhasil disimpan.');
            } else {
                return redirect()->back()->with('toast_error', 'Gagal upload file');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function editBobot(IKU7 $pelaporan)
    {
        $pelaporan->load('mataKuliah');
        return view('dashboard.pelaporan-prodi.edit-bobot', compact('pelaporan'));
    }

    public function editDeskripsi(IKU7 $pelaporan)
    {
        $pelaporan->load('mataKuliah');
        return view('dashboard.pelaporan-prodi.edit-deskripsi', compact('pelaporan'));
    }

    public function updateBobot(Request $request, IKU7 $pelaporan)
    {
        $validatedData = $request->validate([
            'bobot_case_method' => ['required', 'numeric', 'min:50', 'max:100'],
            'bobot_project_based' => ['required', 'numeric', 'min:50', 'max:100'],
            'bobot_kognitif_tugas' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_kuis' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uts' => ['required', 'numeric', 'min:0', 'max:100'],
            'bobot_kognitif_uas' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        DB::beginTransaction();

        try {
            $pelaporan->score_case_method = $validatedData['bobot_case_method'];
            $pelaporan->score_project_based = $validatedData['bobot_project_based'];
            $pelaporan->score_cognitive_task = $validatedData['bobot_kognitif_tugas'];
            $pelaporan->score_cognitive_quiz = $validatedData['bobot_kognitif_kuis'];
            $pelaporan->score_cognitive_uts = $validatedData['bobot_kognitif_uts'];
            $pelaporan->score_cognitive_uas = $validatedData['bobot_kognitif_uas'];
            $pelaporan->save();

            DB::commit();
            return redirect()->route('dashboard.pelaporan-prodi.index')->with('toast_success', 'Data Bobot Mata Kuliah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function updateDeskripsi(Request $request, IKU7 $pelaporan)
    {
        $validatedData = $request->validate([
            'deskripsi_penilaian_case_method' => ['required', 'string'],
            'deskripsi_penilaian_project_based' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_tugas' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_kuis' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_uts' => ['required', 'string'],
            'deskripsi_penilaian_kognitif_uas' => ['required', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $pelaporan->description_case_method = $validatedData['deskripsi_penilaian_case_method'];
            $pelaporan->description_project_based = $validatedData['deskripsi_penilaian_project_based'];
            $pelaporan->description_cognitive_task = $validatedData['deskripsi_penilaian_kognitif_tugas'];
            $pelaporan->description_cognitive_quiz = $validatedData['deskripsi_penilaian_kognitif_kuis'];
            $pelaporan->description_cognitive_uts = $validatedData['deskripsi_penilaian_kognitif_uts'];
            $pelaporan->description_cognitive_uas = $validatedData['deskripsi_penilaian_kognitif_uas'];
            $pelaporan->save();

            DB::commit();
            return redirect()->route('dashboard.pelaporan-prodi.index')->with('toast_success', 'Data Deskripsi Mata Kuliah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function updateRPS(Request $request, IKU7 $pelaporan)
    {
        $validatedData = $request->validate([
            'file_rps' => ['required', 'file', 'mimes:pdf', 'max:2048'],
        ]);

        DB::beginTransaction();

        try {
            $file = $request->file('file_rps');

            $fileName = time() . '_' . $pelaporan->mataKuliah->code . '_' . $pelaporan->mataKuliah->name . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs('public/rps', $fileName);
            $formattedFilePath = str_replace('public', '/storage', $filePath);

            $pelaporan->file_rps = $formattedFilePath;

            $pelaporan->save();

            DB::commit();
            return redirect()->route('dashboard.pelaporan-prodi.index')->with('toast_success', 'Data RPS Mata Kuliah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function view(IKU7 $daftar_pelaporan): View
    {
        $daftar_pelaporan->load('mataKuliah');
        $mimeType = mime_content_type($daftar_pelaporan->file_rps);

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
