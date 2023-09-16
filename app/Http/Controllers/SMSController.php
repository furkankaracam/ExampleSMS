<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Get (
 *     path="/api/sms",
 *     summary="Mesaj raporları",
 *     tags = {"SMS Servis"},
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *         name="date",
 *         description="Tarihe göre filtreleme (Y-m-d) (OPSİYONEL)",
 *         required=false,
 *         in="query",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Raporlar başarıyla getirildi",
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Yetkisiz",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Sunucu hatası",
 *     ),
 * )
 */

/**
 * @OA\Get (
 *     path="/api/sms/show/{id}",
 *     summary="Mesaj rapor detayı",
 *     tags = {"SMS Servis"},
 *     security={{ "bearerAuth":{} }},
 *     @OA\Parameter(
 *         name="id",
 *         description="Mesaj ID'si",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Rapor başarıyla getirildi",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Sunucu hatası",
 *     ),
 * )
 */

/**
 * @OA\Post(
 *     path="/api/sms/send",
 *     summary="Sms gönderme",
 *     tags = {"SMS Servis"},
 *     security={{ "bearerAuth":{} }},
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
 *                 example="kullanici_adi"
 *             ),
 *             @OA\Property(
 *                 property="number",
 *                 type="string",
 *                 format="string",
 *                 example="+905442241798"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Gönderilen mesaj içeriği"
 *             ),
 *         )
 *     )
 * ),
 *     @OA\Response(
 *         response=200,
 *         description="Mesaj başarıyla gönderildi",
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Yetkisiz",
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Hatalı veya eksik veri girişi",
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Sunucu hatası",
 *     ),
 * )
 */

class SMSController extends Controller
{
    public function index(Request $request)
    {
        if ($request->header('authorization')) {
            $messages = Sms::all();

            //Tarihe göre filtreleme
            if ($request->date) {
                $date = Carbon::parse($request->date);
                $filtered_messages = Sms::whereDate('created_at', $date)->get();
                return response()->json(['data' => $filtered_messages], 200);
            } else {
                return response()->json(['data' => $messages], 200);
            }
        } else {
            return response()->json(['error' => "Yetkisiz erişim"], 401);
        }
    }

    public function show($id)
    {
        $message = Sms::where('id', $id)->first();

        if ($message) {
            return response()->json(['status' => true, 'data' => $message], 200);
        } else {
            return response()->json(['status' => false], 500);
        }

    }


    public function sendSms(Request $request)
    {
        $token = $request->header('Authorization');

        try {
            $user = JWTAuth::parseToken()->authenticate();

            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'number' => 'required',
                'message' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'data' => $validator->errors()->all()], 422);
            } else {
                $sms = [
                    "username" => $user->username,
                    "number" => $request->number,
                    "message" => $request->message
                ];

                $send = Sms::create($sms);

                if ($sms) {
                    return response()->json(['status' => true, 'data' => $sms], 200);
                } else {
                    return response()->json(['status' => false, 'data' => $send], 500);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'data' => $sms], 401);
        }
    }
}
