<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function change_password()
    {                          
        return view('account.change-password');
    }

    public function store_password(Request $request)
    {
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->current_password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),   
            ]);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect(route('account.index'))->with('message', 'Your password was modified successfully.');
    }
}

