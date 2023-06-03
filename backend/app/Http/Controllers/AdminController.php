<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Pemilihan;
use App\Models\User;
use App\Models\Vote;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function profile(Request $request) {
        $token = $request->bearerToken();
        $u = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $user = User::find($u->sub);
        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function get_all_pemilihan(Request $request) {
        $pemilihan = Pemilihan::with('kandidat')->get();

        foreach ($pemilihan as $p) {
            $p['total_vote'] = Vote::where('pemilihan_id', $p->id)->count();
            $p['image'] = url($p->image);
            $periode = explode('-', $p->tanggal_mulai);
            $p['periode'] = $periode[0];

            $kandidat = Kandidat::where('id_pemilihan', $p->id)->get();
            foreach ($kandidat as $k) {
                $k['vote_count'] = Vote::where('kandidat_id', $k->id)->count();
                $k['image'] = url($k->image);
            }

            unset($p->kandidat);
            $p['kandidat'] = $kandidat;
        }

        return response()->json([
            'message' => 'success',
            'data' => $pemilihan
        ]);
    }

    public function get_pemilihan(Request $request, $id) {
        $pemilihan = Pemilihan::with('kandidat')->find($id);
        if (!$pemilihan) return response()->json([
            'message' => 'pemilihan tidak ditemukan',
            'data' => null
        ], 404);

        $pemilihan['total_vote'] = Vote::where('pemilihan_id', $pemilihan->id)->count();
        $pemilihan['image'] = url('images/' . $pemilihan->image);

        // get kandidat
        $kandidat = Kandidat::where('id_pemilihan', $pemilihan->id)->get();
        foreach ($kandidat as $k) {
            $k['vote_count'] = Vote::where('kandidat_id', $k->id)->count();
        }

        unset($pemilihan->kandidat);
        $pemilihan['kandidat'] = $kandidat;

        return response()->json([
            'message' => 'success',
            'data' => $pemilihan
        ]);
    }

    public function create_pemilihan(Request $request) {
        $v = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'image' => 'required|mimes:jpg,jpeg,png',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $image = $request->file('image');
        $image_name = time() . '.' . $image->extension();
        $image->move(public_path('images'), $image_name);

        try {
            $pemilihan = Pemilihan::create([
                'nama_pemilihan' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'status' => 'active',
                'image' => 'images/' . $image_name,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $pemilihan
            ], 201);
        } catch (\Throwable $th) {
            if (file_exists(public_path('images/' . $image_name))) unlink(public_path('images/' . $image_name));

            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function update_pemilihan(Request $request, $id) {
        $pemilihan = Pemilihan::find($id);
        if (!$pemilihan) {
            return response()->json([
                'message' => 'failed',
                'data' => 'pemilihan not found'
            ], 404);
        }

        $v = Validator::make($request->all(), [
            'nama' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|in:active,inactive',
            'image' => 'mimes:jpg,jpeg,png',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            '__method' => 'required|in:PUT,PATCH'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $image = $request->file('image');
        if ($image) {
            // get name
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images'), $image_name);

            $file_is_exist = file_exists(public_path($pemilihan->image));
            if ($file_is_exist && $pemilihan->image != '') unlink(public_path($pemilihan->image));
        } else {
            $image_name = $pemilihan->image;
        }

        try {
            $pemilihan = Pemilihan::find($id);
            $pemilihan->nama_pemilihan = $request->nama;
            $pemilihan->deskripsi = $request->deskripsi;
            $pemilihan->tanggal_mulai = $request->tanggal_mulai;
            $pemilihan->tanggal_selesai = $request->tanggal_selesai;
            $pemilihan->image = $image ? 'images/' . $image_name : $pemilihan->image;
            $pemilihan->status = $request->status;
            $pemilihan->updated_at = now();
            $pemilihan->save();

            return response()->json([
                'message' => 'success',
                'data' => $pemilihan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function delete_pemilihan(Request $request, $id) {
        $pemilihan = Pemilihan::find($id);
        if (!$pemilihan) {
            return response()->json([
                'message' => 'failed',
                'data' => 'pemilihan not found'
            ], 404);
        }

        try {
            $pemilihan->delete();

            if (file_exists(public_path($pemilihan->image))) unlink(public_path($pemilihan->image));

            return response()->json([
                'message' => 'success',
                'data' => $pemilihan
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function get_all_kandidat(Request $request) {
        $kandidat = Kandidat::all();
        $kandidat->load('KelasKetua', 'KelasWakil', 'pemilihan');

        return response()->json([
            'message' => 'success',
            'data' => $kandidat
        ]);
    }

    public function get_kandidat(Request $request, $id) {
        $kandidat = Kandidat::find($id);
        $kandidat->load('KelasKetua', 'KelasWakil', 'pemilihan');

        if (!$kandidat) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kandidat not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $kandidat
        ]);
    }

    public function create_kandidat(Request $request) {
        $v = Validator::make($request->all(), [
            'image' => 'required|mimes:jpg,jpeg,png',
            'nama_ketua' => 'required|string',
            'id_kelas_ketua' => 'required|exists:kelas,id',
            'nama_wakil' => 'required|string',
            'id_kelas_wakil' => 'required|exists:kelas,id',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'id_pemilihan' => 'required|exists:pemilihans,id'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $image = $request->file('image');
        $image_name = time() . '.' . $image->extension();
        $image->move(public_path('images'), $image_name);

        try {
            $kandidat = Kandidat::create([
                'image' => 'images/' . $image_name,
                'nama_ketua' => $request->nama_ketua,
                'id_kelas_ketua' => $request->id_kelas_ketua,
                'nama_wakil' => $request->nama_wakil,
                'id_kelas_wakil' => $request->id_kelas_wakil,
                'visi' => $request->visi,
                'misi' => $request->misi,
                'id_pemilihan' => $request->id_pemilihan
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $kandidat
            ], 201);
        } catch (\Throwable $th) {
            if (file_exists(public_path('images/' . $image_name))) unlink(public_path('images/' . $image_name));

            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function update_kandidat(Request $request, $id) {
        $v = Validator::make($request->all(), [
            'image' => 'mimes:jpg,jpeg,png',
            'nama_ketua' => 'required|string',
            'id_kelas_ketua' => 'required|exists:kelas,id',
            'nama_wakil' => 'required|string',
            'id_kelas_wakil' => 'required|exists:kelas,id',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'id_pemilihan' => 'required|exists:pemilihans,id',
            '__method' => 'required|in:PUT,PATCH'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $kandidat = Kandidat::find($id);
        if (!$kandidat) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kandidat not found'
            ], 404);
        }

        $image = $request->file('image');
        if ($image) {
            $image_name = time() . '.' . $image->extension();
            $image->move(public_path('images'), $image_name);

            $file_is_exist = file_exists(public_path($kandidat->image));
            if ($file_is_exist && $kandidat->image != '') unlink(public_path($kandidat->image));
        } else {
            $image_name = $kandidat->image;
        }

        try {
            $kandidat->image = $image ? 'images/' . $image_name : $kandidat->image;
            $kandidat->nama_ketua = $request->nama_ketua;
            $kandidat->id_kelas_ketua = $request->id_kelas_ketua;
            $kandidat->nama_wakil = $request->nama_wakil;
            $kandidat->id_kelas_wakil = $request->id_kelas_wakil;
            $kandidat->visi = $request->visi;
            $kandidat->misi = $request->misi;
            $kandidat->id_pemilihan = $request->id_pemilihan;
            $kandidat->updated_at = now();
            $kandidat->save();

            return response()->json([
                'message' => 'success',
                'data' => $kandidat
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function delete_kandidat(Request $request, $id) {
        $kandidat = Kandidat::find($id);
        if (!$kandidat) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kandidat not found'
            ], 404);
        }

        try {
            $file_is_exist = file_exists(public_path($kandidat->image));
            if ($file_is_exist && $kandidat->image != '') unlink(public_path($kandidat->image));

            $kandidat->delete();

            return response()->json([
                'message' => 'success',
                'data' => $kandidat
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function get_all_user(Request $request) {
        $users = User::with('kelas')->get();

        return response()->json([
            'message' => 'success',
            'data' => $users
        ]);
    }

    public function get_user(Request $request, $id) {
        $user = User::with('kelas')->find($id);
        if (!$user) {
            return response()->json([
                'message' => 'failed',
                'data' => 'user not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function create_user(Request $request) {
        $v = Validator::make($request->all(), [
            'nis' => 'unique:users',
            'email' => 'required|email|unique:users',
            'id_kelas' => 'exists:kelas,id',
            'name' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:admin,user'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        try {
            $user = User::create([
                'nis' => $request->nis,
                'email' => $request->email,
                'id_kelas' => $request->id_kelas,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'role' => $request->role
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function update_user(Request $request, $id) {
        $v = Validator::make($request->all(), [
            'nis' => 'unique:users,nis,' . $id,
            'email' => 'email|unique:users,email,' . $id,
            'id_kelas' => 'exists:kelas,id',
            'name' => 'string',
            'password' => 'string',
            'role' => 'required|in:admin,user',
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'failed',
                'data' => 'user not found'
            ], 404);
        }

        try {
            $user->nis = $request->nis;
            $user->email = $request->email;
            $user->id_kelas = $request->id_kelas;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->role = $request->role;
            $user->updated_at = now();
            $user->save();

            return response()->json([
                'message' => 'success',
                'data' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function delete_user(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'message' => 'failed',
                'data' => 'user not found'
            ], 404);
        }

        try {
            $user->delete();

            return response()->json([
                'message' => 'success',
                'data' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function get_all_kelas(Request $request) {
        $kelas = Kelas::all();
        $kelas->load('jurusan');

        return response()->json([
            'message' => 'success',
            'data' => $kelas
        ]);
    }

    public function get_kelas(Request $request, $id) {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kelas not found'
            ], 404);
        }

        $kelas->load('jurusan');

        return response()->json([
            'message' => 'success',
            'data' => $kelas
        ]);
    }

    public function create_kelas(Request $request) {
        $v = Validator::make($request->all(), [
            'nama' => 'required|string',
            'id_jurusan' => 'required|exists:jurusan,id'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        try {
            $kelas = Kelas::create([
                'nama' => $request->nama,
                'id_jurusan' => $request->id_jurusan
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $kelas
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function update_kelas(Request $request, $id) {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kelas not found'
            ], 404);
        }

        $v = Validator::make($request->all(), [
            'nama' => 'required|string',
            'id_jurusan' => 'required|exists:jurusan,id'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        try {
            $kelas->nama = $request->nama;
            $kelas->id_jurusan = $request->id_jurusan;
            $kelas->save();

            return response()->json([
                'message' => 'success',
                'data' => $kelas
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function delete_kelas(Request $request, $id) {
        $kelas = Kelas::find($id);
        if (!$kelas) {
            return response()->json([
                'message' => 'failed',
                'data' => 'kelas not found'
            ], 404);
        }

        try {
            $kelas->delete();

            return response()->json([
                'message' => 'success',
                'data' => $kelas
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function get_all_jurusan(Request $request) {
        $jurusan = Jurusan::all();

        return response()->json([
            'message' => 'success',
            'data' => $jurusan
        ]);
    }

    public function get_jurusan(Request $request, $id) {
        $jurusan = Jurusan::find($id);
        if (!$jurusan) {
            return response()->json([
                'message' => 'failed',
                'data' => 'jurusan not found'
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'data' => $jurusan
        ]);
    }

    public function create_jurusan(Request $request) {
        $v = Validator::make($request->all(), [
            'nama' => 'required|string'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        try {
            $jurusan = Jurusan::create([
                'nama' => $request->nama
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $jurusan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function update_jurusan(Request $request, $id) {
        $jurusan = Jurusan::find($id);
        if (!$jurusan) {
            return response()->json([
                'message' => 'failed',
                'data' => 'jurusan not found'
            ], 404);
        }

        $v = Validator::make($request->all(), [
            'nama' => 'required|string'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        try {
            $jurusan->nama = $request->nama;
            $jurusan->save();

            return response()->json([
                'message' => 'success',
                'data' => $jurusan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function delete_jurusan(Request $request, $id) {
        $jurusan = Jurusan::find($id);
        if (!$jurusan) {
            return response()->json([
                'message' => 'failed',
                'data' => 'jurusan not found'
            ], 404);
        }

        try {
            $jurusan->delete();

            return response()->json([
                'message' => 'success',
                'data' => $jurusan
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function dashboard(Request $request) {
        $pemilihan = Pemilihan::count();
        $kandidat = Kandidat::count();
        $kelas = Kelas::count();
        $jurusan = Jurusan::count();
        $user = User::count();
        $vote = Vote::count();

        return response()->json([
            'message' => 'success',
            'data' => [
                'pemilihan' => $pemilihan,
                'kandidat' => $kandidat,
                'kelas' => $kelas,
                'jurusan' => $jurusan,
                'user' => $user,
                'vote' => $vote
            ]
        ]);
    }
}