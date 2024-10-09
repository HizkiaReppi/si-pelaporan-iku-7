<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $faculties = Faculty::all();
        return view('auth.register', compact('concentrations'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'fullname' => ['required', 'string', 'max:255', 'min:2', 'regex:/^[a-zA-Z\s]*$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'min:4', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'faculty_id' => ['required', 'exists:' . Faculty::class . ',id'],
        ], [
            'fullname.regex' => 'The fullname field must be alphabet.',
        ]);

        DB::beginTransaction();

        try {
            $user = new User();
            $user->name = $validatedData['fullname'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->role = 'admin-prodi';
            $user->save();

            $department = new Department();
            $department->user_id = $user->id;
            $department->faculty_id = $validatedData['faculty_id'];
            $department->nim = $validatedData['nim'];
            $department->batch = $validatedData['angkatan'];
            $department->concentration = $validatedData['konsentrasi'];

            $department->save();

            DB::commit();

            return redirect()->back()->with('toast', 'Pendaftaran berhasil. Silahkan menunggu admin memverifikasi akun anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Gagal mendaftar. Silahkan coba lagi.');
        }
    }
}