<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\BaseApiResource;
use App\Http\Resources\UserResource;

class AuthResource extends BaseApiResource
{
    public function toArray(Request $request): array
    {
        return [
            'token' => $this['token'],
            'user'  => new UserResource($this['user']),
        ];
    }
}
