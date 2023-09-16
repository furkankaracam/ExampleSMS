<?php

namespace Tests\Unit;

use App\Models\Sms;
use App\Models\User;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class SMSTest extends TestCase
{
    public function test_can_get_all_sms()
    {
        $user = User::factory()->create([
            'username' => 'test@example.com',
            'password' => "password",
        ]);

        $token = JWTAuth::fromUser($user);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get(route('sms.index'))->assertStatus(200);
    }

    public function test_can_get_filtered_sms()
    {
        $user = User::factory()->create([
            'username' => 'test@example.com',
            'password' => "password",
        ]);

        $token = JWTAuth::fromUser($user);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('sms.index', ['date' => '2023-01-01']))->assertStatus(200);
    }

    public function test_can_get_sms()
    {
        $user = User::factory()->create([
            'username' => 'test@example.com',
            'password' => "password",
        ]);

        $token = JWTAuth::fromUser($user);

        $sms = Sms::create([
            "username" => $user->username,
            "number" => "+905442241798",
            "message" => "Mesaj"
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get(route('sms.show', ['id' => $sms->id]))->assertStatus(200);
    }

    public function test_can_send_sms()
    {
        $user = User::factory()->create([
            'username' => 'test@example.com',
            'password' => "password",
        ]);

        $token = JWTAuth::fromUser($user);

        $sms = [
            "username" => $user->username,
            "number" => "+905442241798",
            "message" => "Mesaj"
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->post(route('sms.store'), $sms)->assertStatus(200);
    }
}
