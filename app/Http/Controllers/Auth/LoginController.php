<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResourceTrait;

class LoginController extends Controller
{
    use ApiResourceTrait;

    public function login(Request $request)
    {
        try {
            $validated = $this->apiValidate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (! $token = auth()->attempt($validated)) {
                return $this->error("Invalid Credentials", 404);
                
            }

            return $this->api($this->getResponse($token));
        } catch (\Exception $e) {
            return $this->safeError($e);
        }
    }

    protected function getResponse($token)
    {
        return [
            'user' => auth()->user(),
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
