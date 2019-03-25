<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResourceTrait;

class MeController extends Controller
{
    use ApiResourceTrait;

    public function me()
    {
        try {
            return $this->api(auth()->user());
        } catch (\Exception $e) {
            return $this->safeError($e);
        }
    }
}
