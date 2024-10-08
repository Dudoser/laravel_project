<?php

namespace App\Http\Middleware;

use App\Repositories\UserTokenRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{

    protected $userTokenRepository;

    public function __construct(UserTokenRepository $userTokenRepository)
    {
        $this->userTokenRepository = $userTokenRepository;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->userTokenRepository->isActive(auth()->user()->userToken)) {
            return redirect()->route('indexAction')->with('error', 'You token is not active.');
        }

        return $next($request);
    }

}
