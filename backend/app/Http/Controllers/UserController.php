<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Pemilihan;
use App\Models\User;
use App\Models\Vote;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        $user = User::with('kelas')->find($user->sub);

        return response()->json([
            'message' => 'success',
            'data' => $user
        ]);
    }

    public function get_all_pemilihan(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $user_id = $user->sub;

        $pemilihan = Pemilihan::with('kandidat')->where('status', 'active')->get();

        foreach ($pemilihan as $p) {
            $p['total_vote'] = Vote::where('pemilihan_id', $p->id)->count();
            $p['image'] = url($p->image);

            $kandidat = Kandidat::where('id_pemilihan', $p->id)->get();
            foreach ($kandidat as $k) {
                $k['vote_count'] = Vote::where('kandidat_id', $k->id)->count();
                $k['image'] = url($k->image);

                // get kelas
                $kelas_ketua = Kelas::find($k->id_kelas_ketua);
                $kelas_wakil = Kelas::find($k->id_kelas_wakil);

                $k['kelas_ketua'] = $kelas_ketua['nama'];
                $k['kelas_wakil'] = $kelas_wakil['nama'];
            }

            // periode split from tanggal_mulai
            $p['periode'] = explode('-', $p->tanggal_mulai)[0];

            $vote = Vote::where('user_id', $user_id)->where('pemilihan_id', $p->id)->first();
            if ($vote)
                $p['already_vote'] = true;
            else
                $p['already_vote'] = false;


            unset($p->kandidat);
            $p['kandidat'] = $kandidat;

            // filter kandidat by total vote
            $p['kandidat'] = $p['kandidat']->sortByDesc('vote_count')->values()->all();
        }

        return response()->json([
            'message' => 'success',
            'data' => $pemilihan
        ]);
    }

    public function get_pemilihan(Request $request, $id) {
        $pemilihan = Pemilihan::with('kandidat')->where('status', 'active')->find($id);
        // check if user already vote
        $token = $request->bearerToken();
        $user = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $user_id = $user->sub;

        $vote = Vote::where('user_id', $user_id)->where('pemilihan_id', $pemilihan->id)->first();
        if ($vote)
            $pemilihan['already_vote'] = true;
        else
            $pemilihan['already_vote'] = false;

        $pemilihan['image'] = url($pemilihan->image);
        $pemilihan['total_vote'] = Vote::where('pemilihan_id', $pemilihan->id)->count();

        // get kandidat
        $kandidat = Kandidat::where('id_pemilihan', $pemilihan->id)->get();
        foreach ($kandidat as $k) {
            $k['vote_count'] = Vote::where('kandidat_id', $k->id)->count();
            $k['image'] = url($k->image);
        }

        unset($pemilihan->kandidat);
        $pemilihan['kandidat'] = $kandidat;

        if (!$pemilihan) return response()->json([
            'message' => 'pemilihan tidak ditemukan',
            'data' => null
        ], 404);

        return response()->json([
            'message' => 'success',
            'data' => $pemilihan
        ]);
    }

    public function vote(Request $request, $id, $id_kandidat) {
        $pemilihan = Pemilihan::with('kandidat')->find($id);
        $kandidat = $pemilihan->kandidat()->find($id_kandidat);

        if (!$pemilihan) return response()->json([
            'message' => 'pemilihan tidak ditemukan',
            'data' => null
        ], 404);

        if (!$kandidat) return response()->json([
            'message' => 'kandidat tidak ditemukan',
            'data' => null
        ], 404);

        // get bearer token
        $token = $request->bearerToken();
        $user = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $user_id = $user->sub;

        // if user already vote
        $vote = Vote::where('user_id', $user_id)->where('pemilihan_id', $pemilihan->id)->first();
        if ($vote) return response()->json([
            'message' => 'anda sudah melakukan vote',
            'data' => null
        ], 400);

        try {
            $kandidat->save();

            $vote = new Vote();
            $vote->user_id = $user_id;
            $vote->pemilihan_id = $pemilihan->id;
            $vote->kandidat_id = $kandidat->id;
            $vote->save();

            return response()->json([
                'message' => 'success',
                'data' => $vote
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    // get all kelas
    public function get_all_kelas(Request $request)
    {
        $kelas = Kelas::all();

        return response()->json([
            'message' => 'success',
            'data' => $kelas
        ]);
    }

    public function update_profile(Request $request) {
        $token = $request->bearerToken();
        $user = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        $user_id = $user->sub;

        $user = User::find($user_id);
        if (!$user) return response()->json([
            'message' => 'user tidak ditemukan',
            'data' => null
        ], 404);


        $v = Validator::make($request->all(), [
            'nama' => 'string',
            'id_kelas' => 'integer',
            'email' => 'email',
            'nis' => 'string',
            'password' => 'string'
        ]);

        if ($v->fails()) return response()->json([
            'message' => 'error',
            'data' => $v->errors()
        ], 400);

        // check if email or nis already exist
        $check = User::where('email', $request->email)->orWhere('nis', $request->nis)->first();
        if ($check && $check->id != $user->id) return response()->json([
            'message' => 'email atau nis sudah digunakan',
            'data' => null
        ], 400);

        try {
            $user->name = $request->nama;
            $user->id_kelas = $request->id_kelas;
            $user->email = $request->email;
            $user->nis = $request->nis;
            $pw = $request->password;
            $user->password =  $pw ? bcrypt($pw) : $user->password;
            $user->save();

            return response()->json([
                'message' => 'success',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'error',
                'data' => $th->getMessage()
            ], 500);
        }
    }

    public function get_all_pemilihan_status(Request $request) {
        $pemilihans = Pemilihan::with('kandidat')->get();

        $completed = [];
        $running = [];
        $upcoming = [];

        foreach ($pemilihans as $p) {
            $p['image'] = url($p->image);
            $p['total_vote'] = Vote::where('pemilihan_id', $p->id)->count();

            // get kandidat
            $kandidat = Kandidat::where('id_pemilihan', $p->id)->get();
            foreach ($kandidat as $k) {
                $k['vote_count'] = Vote::where('kandidat_id', $k->id)->count();
                $k['image'] = url($k->image);
            }

            unset($p->kandidat);
            $p['kandidat'] = $kandidat;

            $start = Carbon::parse($p->tanggal_mulai);
            $end = Carbon::parse($p->tanggal_selesai);

            // upcoming, running, completed
            if ($start->isFuture()) {
                $p['status'] = 'upcoming';
                array_push($upcoming, $p);
            } else if ($end->isPast()) {
                $p['status'] = 'completed';
                array_push($completed, $p);
            } else {
                $p['status'] = 'running';
                array_push($running, $p);
            }
        }

        return response()->json([
            'message' => 'success',
            'data' => [
                'upcoming' => $upcoming,
                'running' => $running,
                'completed' => $completed
            ]
        ]);
    }
}