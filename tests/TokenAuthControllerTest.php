<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TokenAuthControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterUser()
    {
        $email = str_random(10).'@gmail.com';

        $this->json('POST', '/api/v1/register', [
            'first_name'      => 'Harold',
            'last_name'       => 'Kumar',
            'email'           => $email,
            'phone'           => '761-434-5132',
            'npi'             => 35388964,
            'speciality_code' => 741648715,
            'password'        => 'password'
        ])->seeStatusCode(201)
            ->seeJson([
                'email' => $email
            ]);
    }

    public function testAuthenticateUser()
    {
        $this->json('POST', '/api/v1/authenticate', [
            'email' => 'hkumar@yahoo.com',
            'password' => 'password'
        ])->seeStatusCode(200)
            ->seeJsonStructure([
                'token'
            ]);
    }

}
