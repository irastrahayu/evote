<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->only(['nis', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $payload = [
            'role' => 'user',
            'sub' => auth()->user()->id,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 7
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'success',
            'data' => [
                'token' => $token,
                'user' => auth()->user()
            ]
        ]);
    }

    public function register(Request $request) {
        $v = Validator::make($request->all(), [
            'nis' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'id_kelas' => 'required|integer',
            'password' => 'required|string|min:6'
        ]);

        if ($v->fails()) {
            $errs = $v->errors()->all();
            $err = join(', ', $errs);

            return response()->json([
                'message' => 'validation error',
                'data' => $err
            ], 400);
        }

        $kelas = Kelas::find($request->id_kelas);
        if (!$kelas) return response()->json([
            'message' => 'kelas tidak ditemukan',
            'data' => null
        ], 404);

        $nim = User::where('nis', $request->nis)->first();
        if ($nim) return response()->json([
            'message' => 'nis sudah terdaftar',
            'data' => null
        ], 400);

        $user = User::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'email' => $request->email,
            'id_kelas' => $request->id_kelas,
            'password' => bcrypt($request->password),
            'role' => 'user'
        ]);

        $payload = [
            'role' => 'user',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 7
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'success',
            'data' => [
                'token' => $token,
                'user' => $user
            ]
        ]);
    }

    public function login_admin(Request $request) {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $payload = [
            'role' => 'admin',
            'sub' => auth()->user()->id,
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 7
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'success',
            'data' => [
                'token' => $token,
                'user' => auth()->user()
            ]
        ]);
    }
}
