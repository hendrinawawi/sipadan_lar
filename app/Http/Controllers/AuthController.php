<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function index()
    {
        // Generate angka random antara 1 s.d 10 untuk captcha
        $angka1 = rand(1, 10);
        $angka2 = rand(1, 10);
        $captchaHasil = $angka1 + $angka2;

        // Simpan ke session
        session(['captcha' => $captchaHasil]);

        // Kirim ke view (untuk ditampilkan di form)
        return view('login', compact('angka1', 'angka2'));
    }

    /**
     * Proses login.
     */
    public function store(Request $request)
    {
        // dump($request->username, $request->password);
        // dump('Input captcha:', $request->captcha);
        // dump('Session captcha:', session('captcha'));

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha'  => 'required|numeric',
        ]);

        // Validasi captcha
        if ($request->captcha != session('captcha')) {
            return back()->withErrors(['captcha' => 'Kombinasi inputan salah'])->withInput();
        }

        // Cek user
        $user = DB::table('users')->where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Username atau password salah'])->withInput();
        }

        // Login manual
        Auth::loginUsingId($user->id);

        // Hapus captcha dari session setelah login
        session()->forget('captcha');

        // Redirect ke dashboard
        return redirect()->route('admin.dashboard')->with('success', 'Login berhasil.');
    }

    //Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('status', 'Anda sudah logout.');
    }

    // Metode bawaan resource tidak digunakan
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'nama_lengkap' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Simpan user ke database
        DB::table('users')->insert([
            'username'     => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'password'     => Hash::make($request->password), // gunakan bcrypt!
            'created_at'   => now(),
            'updated_at'   => now(),
            'level'        => '1',
            'email'        => $request->email,
        ]);

        // Redirect ke login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function create()
    {
        return view('register');
    }

    public function show(string $id)
    {
        abort(404);
    }
    public function edit(string $id)
    {
        abort(404);
    }
    public function update(Request $request, string $id)
    {
        abort(404);
    }
    public function destroy(string $id)
    {
        abort(404);
    }
}