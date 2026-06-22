<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        // Query users where roles contains 'peserta', select id, name, agency.
        $users = User::whereJsonContains('roles', 'peserta')
            ->select('id', 'name', 'agency')
            ->get();

        // Group the users by agency for the frontend
        $groupedUsers = $users->groupBy('agency');

        return view('auth.login', compact('groupedUsers'));
    }

    /**
     * Handle the login request using user id.
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
        ], [
            'user_id.required' => 'Sila pilih agensi dan nama anda.',
            'user_id.exists' => 'Pengguna tidak sah atau tidak dijumpai.'
        ]);

        // Authenticate the user instantly using their ID
        Auth::loginUsingId($request->user_id);

        $request->session()->regenerate();

        $user = Auth::user();

        // Maintain strict role-based redirection logic (ignore intended)
        if ($user->hasRole('admin')) {
            return redirect('/admin/dashboard');
        }

        if ($user->hasRole('jawatankuasa')) {
            return redirect('/secretariat/dashboard');
        }

        return redirect('/dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Show the admin login form.
     */
    public function showAdminLogin()
    {
        return view('auth.admin_login');
    }

    /**
     * Handle the admin login request using email and password.
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Sila masukkan e-mel anda.',
            'email.email' => 'Format e-mel tidak sah.',
            'password.required' => 'Sila masukkan kata laluan.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect('/admin/dashboard');
            }

            if ($user->hasRole('jawatankuasa')) {
                return redirect('/secretariat/dashboard');
            }

            // Fallback for non-admin attempting to login via this route
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akaun anda tiada akses pentadbir.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'E-mel atau kata laluan tidak sah.',
        ])->onlyInput('email');
    }
}
