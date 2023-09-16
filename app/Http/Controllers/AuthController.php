<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Post(
 *     path="/api/auth/register",
 *     summary="Kullanıcı kayıt işlemi",
 *     tags = {"Kullanıcı"},
 * @OA\RequestBody(
 *     request="UserRegisterRequest",
 *     description="Kullanıcı adı ve parola zorunlu alanlar, Kullanıcı adı benzersiz olmalı",
 *     required=false,
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(
 *                 property="username",
 *                 type="string",
 *                 example="username"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 format="password",
 *                 example="password"
 *             ),
 *         )
 *     )
 * ),
 *     @OA\Response(
 *         response=200,
 *         description="Kayıt Başarılı",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Eksik veya Hatalı veri girişi",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Sunucu hatası",
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/auth/login",
 *     summary="Kullanıcı giriş işlemi yapıldıktan sonra geriye JWT Token döndürür",
 *     tags = {"Kullanıcı"},
 * @OA\RequestBody(
 *     request="UserLoginRequest",
 *     description="Kullanıcı adı ve parola ile giriş yapılabilir",
 *     required=false,
 *     @OA\MediaType(
 *         mediaType="application/json",
 *         @OA\Schema(
 *             type="object",
 *             @OA\Property(
 *                 property="username",
 *                 type="string",
 *                 example="username"
 *             ),
 *             @OA\Property(
 *                 property="password",
 *                 type="string",
 *                 format="password",
 *                 example="password"
 *             ),
 *         )
 *     )
 * ),
 *     @OA\Response(
 *         response=200,
 *         description="Giriş Başarılı",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Eksik veya Hatalı veri girişi",
 *     )
 * )
 */

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'data' => $validator->errors()->all()], 422);
        } else {
            $user = [
                "username" => $request->username,
                "password" => $request->password
            ];
            $data = User::create($user);
        }

        if ($data) {
            return response()->json(['status' => true, 'data' => $data], 200);
        } else {
            return response()->json(['status' => false, 'data' => $user], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {

            $token = JWTAuth::fromUser(auth()->user());

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Hatalı Kullanıcı.'], 422);
        }
    }
}
