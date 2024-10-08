<?php

namespace App\Repositories;

use App\Models\UserToken;
use Illuminate\Support\Facades\Auth;

class UserTokenRepository
{
    private $tokenValidityDay = 7;

    public function create(string $token, $user = null): UserToken
    {
        $user = $user ?? Auth::user();

        return UserToken::updateOrCreate(
            ['user_id' => $user->id],
            [
                'token' => $token,
                'expires_at' => now()->addDays($this->tokenValidityDay),
            ]
        );

    }

    public function deactivate(): bool
    {
        $token = Auth::user()->userToken;
        $token->expires_at = now();
        $token->save();
        return true;
    }

    public function isActive( $token) : bool
    {
        return $token->expires_at && $token->expires_at->isFuture();
    }


}
