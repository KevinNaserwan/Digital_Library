<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerprocess(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=\S*?[A-Z])(?=\S*?[a-z])\S*?[!@#$%^&*()]/'
            ],
        ]);

        // Buat dan simpan user baru
        $user = User::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'role' => 'user',
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil!, Silakan Login dengan akun yang anda punya');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Simpan role dalam session
            session(['role' => $user->role, 'name' => $user->username]);

            return redirect()->route('dashboard');
        }

        return redirect()->route('login')->with('error', 'Login gagal. Periksa kembali username dan password.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
