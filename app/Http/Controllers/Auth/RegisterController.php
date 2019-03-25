<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResourceTrait;

class RegisterController extends Controller
{
    use ApiResourceTrait;

    public function register()
    {
        try {
            $validated = $this->apiValidate([
                'name'  => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
                
            $validated['password'] = bcrypt($validated['password']);
            
            User::create($validated);

            if (!$token = auth()->attempt(request(['email', 'password']))) {
                return $this->error("Invalid Credentials", 401);
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
