<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateUserInfoController extends Controller
{
    public function updateName()
    {
        $info = request()->validate([
            'name' => 'required'
        ]);
        $name = $info['name'];

        auth()->user()->update([
            'name' => $name
        ]);
        
        return redirect()->back()->with('message', 'Your name was modified successfully.');
    }
}
