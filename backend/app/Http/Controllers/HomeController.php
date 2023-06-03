<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {

        $jp = Pemilihan::count();
        $kandidat = Kandidat::count();
        $user = User::count();

        $pemilihans = Kandidat::with('Pemilihan')->get();
        // dd($pemilihans);


        return view('dashboard', compact('pemilihans','jp','kandidat','user'));
    }
}
