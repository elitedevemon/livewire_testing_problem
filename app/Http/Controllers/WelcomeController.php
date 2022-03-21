<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class WelcomeController extends Controller
{
    public function home()
    {                    
        $packages = Package::with(['package_daily_credit', 'package_closet_size'])
                            ->orderBy('package_daily_credit_id', 'ASC')
                            ->orderBy('package_closet_size_id', 'ASC')
                            ->get();
                            
        return view('welcome', [
            'packages' => $packages,
        ]);
    }
}
