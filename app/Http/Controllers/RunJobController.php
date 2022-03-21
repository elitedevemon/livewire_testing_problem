<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Error;
use App\Models\JobStatus;

use App\Jobs\RunJob;

class RunJobController extends Controller
{  
    public function dashboard()
    {  
        return view('dashboard');
    }  
}
