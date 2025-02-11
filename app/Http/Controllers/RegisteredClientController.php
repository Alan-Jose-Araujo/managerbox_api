<?php

namespace App\Http\Controllers;


use App\Http\Requests\Auth\StoreRegisteredClientRequest;
use App\Models\Address;
use App\Models\Company;
use App\Models\Metier;
use App\Models\PersonalRefreshToken;
use App\Models\User;
use App\Traits\Http\SendJsonResponses;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisteredClientController extends Controller
{
    use SendJsonResponses;

   public function register(StoreRegisteredClientRequest $request)
   {
       try
       {
           $companyData = array_filter($request->all(), function($key) {
               return preg_match_all('/^company_\D+$/', $key);
           }, ARRAY_FILTER_USE_KEY);

           $userData = array_filter($request->all(), function($key) {
               return preg_match_all('/^user_\D+$/', $key);
           }, ARRAY_FILTER_USE_KEY);

           $companyAddressData = array_filter($request->all(), function($key) {
               return preg_match_all('/^company_address_\D+$/', $key);
           }, ARRAY_FILTER_USE_KEY);

           $userHasTheSameAddressAsTheCompany = $request->boolean('user_has_the_same_address_as_the_company');

           $userAddressData = array_filter($request->all(), function($key) {
               return preg_match_all('/^user_address_\D+$/', $key);
           }, ARRAY_FILTER_USE_KEY);

           DB::beginTransaction();

           $metierId = Metier::where('cnae_code', '=', $request->input('cnae_code'))->first()->id;

           $company = Company::create([
               'fantasy_name' => $companyData['company_fantasy_name'],
               'corporate_reason' => $companyData['company_corporate_reason'],
               'email' => $companyData['company_email'],
               'cnpj' => $companyData['company_cnpj'],
               'state_registration' => $companyData['company_state_registration'],
               'foundation_date' => $companyData['company_foundation_date'],
               'company_landline' => $companyData['company_landline'],
               'metier_id' => $metierId,
           ]);

           $user = User::create([
               'name' => $userData['user_name'],
               'email' => $userData['user_email'],
               'password' => $userData['user_password'],
               'cpf' => $userData['user_cpf'],
               'phone_number' => $userData['user_phone_number'],
               'last_activity' => now()->format('Y-m-d H:i:s'),
               'company_id' => $company->id,
           ]);

           // Company address.
           $companyAddress = Address::create([
               'street' => $companyAddressData['company_address_street'],
               'building_number' => $companyAddressData['company_address_building_number'],
               'complement' => $companyAddressData['company_address_complement'],
               'neighborhood' => $companyAddressData['company_address_neighborhood'],
               'city' => $companyAddressData['company_address_city'],
               'state' => $companyAddressData['company_address_state'],
               'zipcode' => $companyAddressData['company_address_zipcode'],
               'country' => $companyAddressData['company_address_country'],
               'addressable_type' => Company::class,
               'addressable_id' => $company->id,
           ]);

           if($userHasTheSameAddressAsTheCompany) {
               Address::create([
                   'street' => $userAddressData['user_address_street'],
                   'building_number' => $userAddressData['user_address_building_number'],
                   'complement' => $userAddressData['user_address_complement'],
                   'neighborhood' => $userAddressData['user_address_neighborhood'],
                   'city' => $userAddressData['user_address_city'],
                   'state' => $userAddressData['user_address_state'],
                   'zipcode' => $userAddressData['user_address_zipcode'],
                   'country' => $userAddressData['user_address_country'],
                   'addressable_type' => User::class,
                   'addressable_id' => $user->id,
               ]);
           }
           else {
               $userAddress = $companyAddress->replicate();
               $userAddress->addressable_type = User::class;
               $userAddress->addressable_id = $user->id;
               $userAddress->created_at = now()->format('Y-m-d H:i:s');
               $userAddress->save();
           }

           $accessToken = $user->createToken('access_token')->plainTextToken;
           $refreshToken = PersonalRefreshToken::generate($user);

           DB::commit();

           return response()->json([
               'success' => true,
               'access_token' => $accessToken,
           ], Response::HTTP_CREATED)->cookie('refresh_token', $refreshToken->token, 60 * 24 * 7, '/', null, true, true);
       }
       catch (\Exception $exception)
       {
           DB::rollBack();
           Log::error($exception);
           return $this->sendErrorResponse();
       }
   }
}
