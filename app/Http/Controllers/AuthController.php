<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\User;

class AuthController extends Controller
{
    //
    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
    
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }
    
        public function register(Request $request)
        {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:professeur'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            $user = User::create([
                'name' => $validatedData['name'],
                'prenom' => $validatedData['prenom'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
    
            Auth::login($user);
    
            return redirect('/');
        }

        public function logout(Request $request)
        {
            Auth::logout();
            
            $request->session()->invalidate();
            
            $request->session()->regenerateToken();
            
            return redirect('/');
        }
    
}
