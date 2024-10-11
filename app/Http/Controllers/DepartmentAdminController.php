<?php

namespace App\Http\Controllers;

use App\Helpers\StatusHelper;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules;

class DepartmentAdminController extends Controller
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
            $model = User::where('role', 'admin-prodi')->with(['prodi', 'prodi.fakultas']);

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('fakultas', function ($row) {
                    return $row->prodi->fakultas->name;
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge text-bg-' .
                        StatusHelper::parseUserBadgeClassNameStatus($row->status) .
                        '">
                            ' .
                        StatusHelper::parseUserStatus($row->status) .
                        '
                        </span>';
                })
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                            href="' .
                        route('dashboard.admin-prodi.show', $row->id) .
                        '">
                                            <i class="bx bxs-user-detail me-1"></i> Detail
                                        </a>
                                        <a href="' .
                        route('dashboard.admin-prodi.edit', $row->id) .
                        '" class="dropdown-item btn-edit">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item"
                                            href="' .
                        route('dashboard.admin-prodi.destroy', $row->id) .
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

        return view('dashboard.admin-prodi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $faculties = Faculty::all();
        $departments = Department::all();
        return view('dashboard.admin-prodi.create', compact('faculties', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_id' => ['required', 'exists:' . Department::class . ',id'],
            'email' => ['required', 'string', 'email', 'max:255', 'min:4', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'faculty_id' => ['required', 'exists:' . Faculty::class . ',id'],
        ]);

        DB::beginTransaction();

        try {
            $department = Department::where('id', $validatedData['department_id'])->first();

            $user = new User();
            $user->name = $department->name;
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->department_id = $validatedData['department_id'];
            $user->role = 'admin-prodi';
            $user->status = 'approved';

            $user->save();

            DB::commit();
            return redirect()->route('dashboard.admin-prodi.index')->with('toast_success', 'Program Studi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Gagal menambahkan Program Studi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $program_studi)
    {
        $program_studi->load(['user', 'fakultas']);
        return view('dashboard.admin-prodi.show', compact('program_studi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Department $program_studi)
    {
        $validatedData = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        DB::beginTransaction();

        try {
            $program_studi->user->status = $validatedData['status'];
            $program_studi->user->save();

            DB::commit();
            return redirect()
                ->route('dashboard.admin-prodi.show', $program_studi->id)
                ->with('toast_success', 'Status Akun Program Studi berhasil diperbaharui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Gagal memperbaharui status akun Program Studi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
