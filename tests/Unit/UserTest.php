<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = \App\Models\User::create([
            'username' => 'test',
            'name' => 'test',
            'email' => 'test@test.com',
            'password'=> '12345678',
        ]);

        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'email' => 'test@test.com',
        ]);
    }
}
