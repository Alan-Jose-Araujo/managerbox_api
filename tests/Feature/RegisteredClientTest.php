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

    private function getMockedClientModels(): array
    {
        // TODO: Mover esta lógica para um módulo externo.
        $company = Company::factory()->make();
        $companyAddress = Address::factory()->make([
            'addressable_type' => Company::class,
            'addressable_id' => $company->id
        ]);
        $user = User::factory()->make([
            'company_id' => $company->id,
        ]);
        $userAddress = Address::factory()->make([
            'addressable_type' => User::class,
            'addressable_id' => $user->id
        ]);

        return [
            'company' => $company,
            'company_address' => $companyAddress,
            'user' => $user,
            'user_address' => $userAddress
        ];
    }

    /**
     * A basic feature test example.
     */
    public function test_client_can_be_registered_successfully(): void
    {
        $mockedClientModels = $this->getMockedClientModels();
        $company = $mockedClientModels['company'];
        $companyAddress = $mockedClientModels['company_address'];
        $user = $mockedClientModels['user'];
        $userAddress = $mockedClientModels['user_address'];

        $requestBody = [
            'company_fantasy_name' => $company->fantasy_name,
            'company_corporate_reason' => $company->corporate_reason,
            'company_email' => $company->email,
            'company_cnpj' => $company->cnpj,
            'company_state_registration' => $company->state_registration,
            'company_foundation_date' => $company->foundation_date,
            'company_landline' => $company->landline,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_password' => $user->password,
            'user_cpf' => $user->cpf,
            'user_phone_number' => $user->phone_number,
            'company_address_street' => $companyAddress->street,
            'company_address_building_number' => $companyAddress->building_number,
            'company_address_complement' => $companyAddress->complement,
            'company_address_neighborhood' => $companyAddress->neighborhood,
            'company_address_city' => $companyAddress->city,
            'company_address_state' => $companyAddress->state,
            'company_address_zipcode' => $companyAddress->zipcode,
            'company_address_country' => $companyAddress->country,
            'user_wants_to_register_address' => true,
            'user_address_street' => $userAddress->street,
            'user_address_building_number' => $userAddress->building_number,
            'user_address_complement' => $userAddress->complement,
            'user_address_neighborhood' => $userAddress->neighborhood,
            'user_address_city' => $userAddress->city,
            'user_address_state' => $userAddress->state,
            'user_address_zipcode' => $userAddress->zipcode,
            'user_address_country' => $userAddress->country,
        ];

        $response = $this->postJson('/api/register', $requestBody);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'success',
            'access_token',
        ]);
        $response->assertCookie('refresh_token');

        $this->assertDatabaseHas('companies', [
            'cnpj' => $company->cnpj,
        ]);
        $this->assertDatabaseHas('addresses', [
            'addressable_type' => Company::class,
        ]);
        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);
        $this->assertDatabaseHas('addresses', [
            'addressable_type' => User::class,
        ]);
    }
}
