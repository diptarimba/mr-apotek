<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\RoleHome;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class LoginRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
    }
    public function login()
    {
        return view('page.auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $emailCredentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];

        $usernameCredentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $auth = Auth::attempt($emailCredentials);
        } else {
            $auth = Auth::attempt($usernameCredentials);
        }

        $dataRaw = RoleHome::get();
        $roleHome = $dataRaw->pluck('home', 'name')->toArray();
        if ($auth) {
            $request->session()->regenerate();
            $role = Auth::user()->getRoleNames()->first();
            if (array_key_exists($role, $roleHome)) {
                return redirect()->route($roleHome[$role])->with('success', 'Login successfully');
            }
            return $this->logout();
        } else {
            return redirect()->route('login.index')->with('error', 'Username or password is incorrect');
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        return redirect()->route('login.index');
    }

    public function reset_index()
    {
        return view('page.auth.email-to-reset-pass');
    }

    public function change_password($token)
    {
        return view('page.auth.reset-pass', compact('token'));
    }

    public function reset_store($token, Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = User::whereHas('password_reset_token', function($query) use ($token){
            $query->where('token', $token);
            $query->where('used', false);
        })->first();

        if($user){
            $user->update([
                'password' => bcrypt($request->password),
            ]);
            $user->password_reset_token()->update([
                'used' => true
            ]);
            return redirect()->route('login.index')->with('success', 'Password reset successfully');
        }

        return redirect()->route('login.index')->with('error', 'Password reset failed');
    }

    public function reset_send(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email'
        ]);

        $user = User::with('password_reset_token')->where('email', $request->email)->first();
        if($user){
            $token = Uuid::uuid4();
            $user->password_reset_token()->create([
                'token' => $token
            ]);

            $details = [
                'reset_link' => route('change_password.index', $token)
            ];

            Mail::to($user->email)->send(new ResetPasswordEmail($details));
            return redirect()->route('login.index')->with('success', 'Email sent successfully');
        }
        return redirect()->route('login.index')->with('error', 'Email not found');
    }
}
