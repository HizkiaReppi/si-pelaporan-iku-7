<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Course;
use App\Models\IKU7;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class PelaporanAdminController extends Controller
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
            $model = Course::with(['pelaporanIku', 'periode', 'prodi'])->get();

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('prodi', function ($row) {
                    return $row->prodi->name;
                })
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
                        route('dashboard.pelaporan-admin.show', $row->pelaporanIku->id) .
                        '">
                                <i class="bx bxs-user-detail me-1"></i> Detail
                            </a>
                                        <a class="dropdown-item"
                                            href="' .
                        route('dashboard.pelaporan-admin.destroy', $row->id) .
                        '"
                                            data-confirm-delete="true">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </a>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('dashboard.pelaporan-admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(IKU7 $daftar_pelaporan): View
    {
        $title = 'Apakah anda yakin?';
        $text = 'Anda tidak akan bisa mengembalikannya!';
        confirmDelete($title, $text);
        
        $daftar_pelaporan->load('mataKuliah');
        return view('dashboard.pelaporan-admin.show', compact('daftar_pelaporan'));
    }

    public function updateVerifikasi(Request $request, IKU7 $daftar_pelaporan)
    {
        $validatedData = $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);

        DB::beginTransaction();

        try {
            $daftar_pelaporan->status_verifikasi = $validatedData['status'];
            $daftar_pelaporan->save();

            DB::commit();
            return redirect()->route('dashboard.pelaporan-admin.index')->with('toast_success', 'Status Verifikasi Mata Kuliah berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IKU7 $daftar_pelaporan)
    {
        DB::beginTransaction();

        try {
            $daftar_pelaporan->delete();
            $daftar_pelaporan->mataKuliah->delete();
            DB::commit();

            return redirect()->route('dashboard.pelaporan-admin.index')->with('toast_success', 'Mata Kuliah berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast_error', 'Gagal menghapus Program Studi.');
        }
    }
}
