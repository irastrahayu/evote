<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Pemilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class KandidatController extends Controller
{
    public function index()
    {
        $kandidat = Kandidat::with('Pemilihan')->get();

        return view('kandidat.kandidat-index', compact('kandidat'));
    }


    public function create()
    {
        $pemilihan = Pemilihan::all();
        return view('kandidat.kandidat-create', compact('pemilihan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'mimetypes:image/jpg,image/png,image/jpeg,image/heif,image/hevc,image/heic|max:8192',
            'NIS_ketua' => 'required|unique:kandidats|max:10',
            'NIS_wakil' => 'required|unique:kandidats|max:10',
            'nama_pasangan' => 'required',
            'nama_ketua' => 'required',
            'nama_wakil' => 'required',
            'kelas_ketua' => 'required',
            'kelas_wakil' => 'required',
            'jurusan_ketua' => 'required',
            'jurusan_wakil' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'program_kerja' => 'required',

        ]);
        $file = $request->file('photo');
        $fileName = $file->getClientOriginalName();
        Storage::put('uploads/img', $file);
        if (!Storage::put('uploads/img', $file)) {
            return redirect()->back()->with(['msg' => 'Gagal Upload']);
        }
        // $lokasiFile = 'Foto Kandidat';
        // $file->move($lokasiFile, $request->nama_pasangan . '-' . $fileName);

        DB::table('kandidats')->insert([
            // Ketua
            'NIS_ketua' => $request->NIS_ketua,
            'nama_ketua' => $request->nama_ketua,
            'kelas_ketua' => $request->kelas_ketua,
            'jurusan_ketua' => $request->jurusan_ketua,
            // Wakil
            'NIS_wakil' => $request->NIS_wakil,
            'nama_wakil' => $request->nama_wakil,
            'kelas_wakil' => $request->kelas_wakil,
            'jurusan_wakil' => $request->jurusan_wakil,
            // Visi & Misi
            'nama_pasangan' => $request->nama_pasangan,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'program_kerja' => $request->program_kerja,
            'foto_kandidat' => $fileName,
            'pemilihan_id' => $request->pemilihan_id
        ]);

        return redirect()->route('kandidat');
    }


    public function edit($id)
    {
        $kandidat = Kandidat::find($id);
        $pemilihan = Pemilihan::all();


        return view('kandidat.kandidat-edit', compact('kandidat', 'pemilihan'));
    }


    public function update($id, Request $request)
    {

        $kandidat = Kandidat::find($id);

        $file = $request->file('foto_kandidat');
        $fileName = $file->getClientOriginalName();
        $lokasiFile = 'Foto Kandidat';

        if ($request->has('foto_kandidat')) {
            if (File::exists('Foto Kandidat/' . $kandidat->foto_kandidat)) {
                File::delete('Foto Kandidat/' . $kandidat->foto_kandidat);
                $file->move($lokasiFile, $request->nama_pasangan . '-' . $fileName);
            } else {
                $file->move($lokasiFile, $request->nama_pasangan . '-' . $fileName);
            }
        }

        $kandidat->foto_kandidat = $request->nama_pasangan . '-' . $fileName;
        $kandidat->nama_pasangan = $request->input('nama_pasangan');
        $kandidat->pemilihan_id = $request->input('pemilihan_id');
        $kandidat->nama_ketua = $request->input('nama_ketua');
        $kandidat->nama_wakil = $request->input('nama_wakil');
        $kandidat->kelas_ketua = $request->input('kelas_ketua');
        $kandidat->kelas_wakil = $request->input('kelas_wakil');
        $kandidat->jurusan_ketua = $request->input('jurusan_ketua');
        $kandidat->jurusan_wakil = $request->input('jurusan_wakil');
        $kandidat->visi = $request->input('visi');
        $kandidat->misi = $request->input('misi');
        $kandidat->program_kerja = $request->input('program_kerja');
        $kandidat->save();

        return redirect()->route('kandidat');
    }


    public function show($id)
    {
        $kandidat = Kandidat::find($id);

        return view('kandidat.kandidat-show', compact('kandidat'));
    }


    public function destroy($id)
    {
        $kandidat = Kandidat::find($id);
        if ($kandidat) {
            File::delete('Foto Kandidat/' . $kandidat->foto_kandidat);
            $kandidat->delete();
        }
        return redirect()->route('kandidat');
    }
}
