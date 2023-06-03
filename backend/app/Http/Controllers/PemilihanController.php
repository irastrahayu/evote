<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemilihanController extends Controller
{
    public function index()
    {
        $pemilihan = Pemilihan::all();
        return view('pemilihan.pemilihan-index',compact('pemilihan'));
    }


    public function create()
    {
        return view('pemilihan.pemilihan-create');
    }

    public function store(Request $request)
    {
        $pemilihan = new Pemilihan();
        $pemilihan->nama_pemilihan = $request->nama_pemilihan;
        $pemilihan->deskripsi = $request->deskripsi;
        $pemilihan->status = "Berjalan";
        $pemilihan->save();

        return redirect()->route('pemilihan');
    }

    public function show($id)
    {

        $pemilihans = Pemilihan::with('Kandidat')->find($id);

        return view('pemilihan.pemilihan-show',compact('pemilihans'));
    }

    public function edit(Pemilihan $pemilihan)
    {
        //
    }

    public function vote($id_pemilihan,$id_kandidat)
    {

        $kandidat = Kandidat::find($id_kandidat);


        if($kandidat) {
            $kandidat->jumlah_suara += 1;
            $kandidat->save();

            $vote = new Vote();
            $vote->user_id = Auth::user()->id ?? 0;
            $vote->kandidat_id = $id_kandidat;
            $vote->pemilihan_id = $id_pemilihan;
            $vote->save();

            return redirect()->back();
        } else {
            session()->flash('error', 'Terdapat.');
            return redirect()->route('pemilihan');

        }


    }

    public function update(Request $request, Pemilihan $pemilihan)
    {
        //
    }

    public function destroy(Pemilihan $pemilihan)
    {
        //
    }
}
