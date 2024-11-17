<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    protected $token;
    protected $user;

    public function __construct($token, $user)
    {
        parent::__construct(null);
        $this->token = $token;
        $this->user = $user;
    }

    public function toArray(Request $request): array
    {
        return [
            'message' => 'Successfully registered',
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'access_token' => $this->token,
            'token_type' => 'Bearer',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode(201);
    }
} 