<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Admin déjà connecté → espace admin
        if (Auth::check()) {
            return Auth::user()->is_admin
                ? redirect()->route('admin.index')
                : redirect()->route('dashboard.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Bloquer les comptes admin sur la page client
            if (Auth::user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Ce compte est réservé à l\'administration. Utilisez l\'accès dédié.']);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'terms'    => 'required|accepted',
        ], [
            'terms.required' => 'Vous devez accepter les CGU et la politique de confidentialité.',
            'terms.accepted' => 'Vous devez accepter les CGU et la politique de confidentialité.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        Mail::to($user->email)->queue(new WelcomeEmail($user));

        return redirect()->route('dashboard.index');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::ResetLinkSent
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])
                     ->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? redirect()->route('client.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /* ── Admin login ─────────────────────────────────────────── */

    public function showAdminLogin()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.index');
        }
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Accès refusé. Ce compte ne dispose pas des droits administrateur.']);
            }

            $request->session()->regenerate();
            return redirect()->route('admin.index');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function adminLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
