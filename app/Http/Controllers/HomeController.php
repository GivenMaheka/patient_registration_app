<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $AUTH_USER; 
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->AUTH_USER = auth()->user();

            return $next($request);
        });
    }
    public function getPatients()
    {
        
        $patients = Patients::all();

        $this->AUTH_USER = auth()->user();

        return view('layouts/patients/patientList', ['data' => $patients, 'user' => json_encode($this->AUTH_USER)]);
    }

    // public function __construct()
    // {

        // $this->middleware(function ($request, $next) {

        //     $AUTH_USER = Auth::user();

        //     return $next($request);
        // });
    // }

    
}
