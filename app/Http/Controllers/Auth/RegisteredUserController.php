<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        $departments = Department::all();
        return view('auth.register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'department_id' => ['required', 'exists:' . Department::class . ',id'],
            'email' => ['required', 'string', 'email', 'max:255', 'min:4', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

            $user->save();

            $user->sendEmailVerificationNotification();

            DB::commit();
            return redirect()->back()->with('success', 'Pendaftaran berhasil. Silahkan menunggu admin memverifikasi akun anda.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('toast_error', 'Gagal mendaftar. Silahkan coba lagi.');
        }
    }
}