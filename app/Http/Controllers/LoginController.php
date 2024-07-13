<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password'  => 'required'
        ]);

        if(Auth::attempt($credentials)) {
            $user = User::where("email", $credentials['email'])->first();

            if ($user->role_id == 3) {
                return redirect()->intended('dashboard-UPPS')->with('success', [
                    'success_title' => 'Login Berhasil!',
                    'success_message' => 'Selamat datang di Halaman UPPS.'
                ]);
                
            }
            if ($user->role_id == 1) {
                return redirect()->intended('dashboard-asesor')->with('success', [
                    'success_title' => 'Login Berhasil!',
                    'success_message' => 'Selamat datang di Halaman Asesor.'
                ]);
            }
            if ($user->role_id == 2) {
                return redirect()->intended('dashboard-prodi')->with('success', [
                    'success_title' => 'Login Berhasil!',
                    'success_message' => 'Selamat datang di Halaman Program Studi.'
                ]);
            }
        }
        // $user = User::where("email", $request->email)->first();

        // if ($user) {
        //     if (Auth::attempt($credentials)) {
        //         $request->session()->regenerate();

        //         if ($user->role_id == "3") {
        //             return redirect('dashboard-UPPS')->with('success', 'Selamat datang di Halaman UPPS!');
        //         } else if ($user->role_id == "2") {
        //             redirect('dashboard-prodi')->with('success', 'Selamat datang di Halaman Program Studi!');
        //         } else if ($user->role_id == "1") {
        //             return redirect('dashboard-asesor')->with('success', 'Selamat datang di Halaman Asesor!');
        //         } else {
        //             return back()->with("loginError", "Tidak Ada Akses");
        //         }
        //     } else {
        //         return back()->with("loginError", "Tidak Ada Data");
        //     }
        // } else {
        //     return back()->with("loginError", "Tidak Ada Akun");
        // }
    }

    public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function forgotpw(Request $request)
    {
        return view ('forgot-password');
    }


    public function pwEmail(Request $request)
    {
        $request->validate(['email' => 'required|email',]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErors(['errors'=>__($status)]);
    }

    public function reset(Request $request, $token)
    {
        return view ('reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                ? redirect('/')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
