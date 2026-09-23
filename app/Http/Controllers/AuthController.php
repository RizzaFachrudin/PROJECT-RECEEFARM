<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('halaman_auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:8'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter'
        ]);

// Mendapatkan data login dari request
        $infologin = $request->only('username', 'password');
        
//melakan autentikasi apakah sebagai login user atau admin dan mengecek apakah password atau username sesuai dengan yang terdaftar di database
        if (Auth::attempt($infologin)) {

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                 ->with('success', 'Halo Admin, Anda berhasil login');
            }

            if (Auth::user()->role === 'user') {
                return redirect()->route('user.dashboard')
                    ->with('success', 'Halo User, Anda berhasil login');
            }

            
            Auth::logout();
            return redirect()->route('login')
                ->withErrors('Role tidak valid');
        }

        // Cek apakah username ada di database
        $user = \App\Models\User::where('username', $request->username)->first();
        
        if (!$user) {
            return back()
                ->withInput()
                ->withErrors([
                    'username' => 'Username tidak terdaftar dalam sistem'
                ]);
        }
        
        // Jika username ada tapi password salah
        return back()
            ->withInput()
            ->withErrors([
                'password' => 'Password yang Anda masukkan salah'
            ]);
    }
}
