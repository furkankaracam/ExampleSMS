<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    public function test_can_register_user()
    {
        $data = [
            'username' => $this->faker->userName,
            'password' => $this->faker->password
        ];

        $this->post(route('user.register'), $data)
            ->assertStatus(200);

    }

    public function test_can_login_user()
    {
        $user = User::factory()->create([
            'username' => $this->faker->userName,
            'password' => 'password'
        ]);


        $response = $this->post(route('user.login'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticated();

    }
}
