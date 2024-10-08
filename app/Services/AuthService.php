<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserTokenRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthService
{

    protected $userRepository;
    protected $tokenService;
    protected $userTokenRepository;

    public function __construct(
        UserRepository $userRepository,
        TokenService $tokenService,
        UserTokenRepository $userTokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenService = $tokenService;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function login(Request $request) : ?User
    {
        $request->validate([
            'username' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        return $this->userRepository->findByLogin($request->username, $request->phone_number);
    }

    public function register(Request $request) : array
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users|max:100',
            'phone_number' => 'required|string|unique:users|max:35',
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator,
                'data' => null
            ];
        }

        $user = $this->userRepository->create([
            'username' => $request->username,
            'phone_number' => $request->phone_number,
        ]);

        $linkToken = $this->userTokenRepository->create($this->tokenService->generateToken(), $user);

        return [
            'status' => true,
            'message' => null,
            'data' => [
                'user' => $user,
                'token' => $linkToken->token,
            ]
        ];
    }
}
