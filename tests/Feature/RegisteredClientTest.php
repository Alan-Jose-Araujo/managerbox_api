<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class RegisteredClientTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_client_can_be_registered_successfully(): void
    {
        $companyCnpj = '12345678901234';
        $userEmail = 'myuser@example.com';
        $requestBody = [
            'company_fantasy_name' => 'My fake company',
            'company_corporate_reason' => 'My fake company .LTDA',
            'company_email' => 'myfakecompany@example.com',
            'company_cnpj' => $companyCnpj,
            'company_state_registration' => '123456789',
            'company_foundation_date' => '2025-01-01',
            'company_landline' => '12345678',
            'user_name' => 'My username',
            'user_email' => $userEmail,
            'user_password' => 'password',
            'user_password_confirmation' => 'password',
            'user_cpf' => '12345678901',
            'user_phone_number' => '123456789',
            'user_birth_date' => '2000-01-01',
            'company_address_street' => 'My company address street',
            'company_address_building_number' => '12345',
            'company_address_complement' => 'ABCDE',
            'company_address_neighborhood' => 'My company address neighborhood',
            'company_address_city' => 'My company city',
            'company_address_state' => 'PE',
            'company_address_zipcode' => '12345678',
            'company_address_country' => 'BR',
            'user_has_the_same_address_as_the_company' => false,
            'user_address_street' => 'My address street',
            'user_address_building_number' => '12345',
            'user_address_complement' => 'ABCDE',
            'user_address_neighborhood' => 'My address neighborhood',
            'user_address_city' => 'My city',
            'user_address_state' => 'PE',
            'user_address_zipcode' => '12345678',
            'user_address_country' => 'BR',
        ];

        $response = $this->postJson('/api/register', $requestBody);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'success',
            'access_token',
        ]);
        $response->assertCookie('refresh_token');

        $this->assertDatabaseHas('companies', [
            'cnpj' => $companyCnpj,
        ]);
        $this->assertDatabaseHas('addresses', [
            'addressable_type' => Company::class,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => $userEmail,
        ]);
        $this->assertDatabaseHas('addresses', [
            'addressable_type' => User::class,
        ]);
    }
}
