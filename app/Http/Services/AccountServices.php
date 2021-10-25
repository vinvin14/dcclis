<?php

namespace App\Http\Services;

use App\Models\AccountRole;
use Exception;
use Illuminate\Support\Facades\Http;

class AccountServices
{
    public function getRoles($account_id)
    {
        AccountRole::query()
        ->where('account', $account_id)
        ->get();
    }

    public function authorize($username, $password)
    {
        try {
            $response = Http::post('http://192.168.224.68:8000/api/account/auth', [
                'username' => $username,
                'password' => $password,
            ]);

            if (empty($token)) {
                return ['error', 'Transaction Failed!'];
            }

            return ['token' => $response->json('token'), 'roles' => $this->getRoles($response->json('account_id'))];

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
    
}
