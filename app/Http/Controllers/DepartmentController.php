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

class DepartmentController extends Controller
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
            $model = Department::with(['user', 'fakultas']);

            return DataTables::of($model)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->user->name;
                })
                ->addColumn('fakultas', function ($row) {
                    return $row->fakultas->name;
                })
                ->addColumn('status', function ($row) {
                    return '<span class="badge text-bg-' . StatusHelper::parseUserBadgeClassNameStatus($row->user->status) . '">
                            '. StatusHelper::parseUserStatus($row->user->status) .'
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
                        route('dashboard.prodi.show', $row->id) .
                        '">
                                            <i class="bx bxs-user-detail me-1"></i> Detail
                                        </a>
                                        <a href="' .
                        route('dashboard.prodi.edit', $row->id) .
                        '" class="dropdown-item btn-edit">
                                            <i class="bx bx-edit-alt me-1"></i> Edit
                                        </a>
                                        <a class="dropdown-item"
                                            href="' .
                        route('dashboard.prodi.destroy', $row->id) .
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

        return view('dashboard.prodi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $faculties = Faculty::all();
        return view('dashboard.prodi.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'min:4', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'faculty_id' => ['required', 'exists:' . Faculty::class . ',id'],
        ], [
            'name.regex' => 'The name field must be alphabet.',
        ]);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->role = 'admin-prodi';
            $user->status = 'approved';

            $user->save();

            $department = new Department();
            $department->user_id = $user->id;
            $department->faculty_id = $validatedData['faculty_id'];

            $department->save();

            DB::commit();
            return redirect()->route('dashboard.prodi.index')->with('toast_success', 'Program Studi berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Gagal menambahkan Program Studi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        //
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
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        //
    }
}
