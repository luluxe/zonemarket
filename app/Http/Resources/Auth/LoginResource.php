<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\Models\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $token = $this->createToken('API', []);

        $user = new UserResource($this);
        return array_merge($user->toArray($request), [
            'token_type' => 'Bearer',
            'access_token' => $token->accessToken,
            'expires_in' => $token->token->expires_at->diffInSeconds(),
        ]);
    }
}
