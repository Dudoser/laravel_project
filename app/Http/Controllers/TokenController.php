<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Repositories\HistoryRepository;
use App\Repositories\UserTokenRepository;
use App\Services\LuckyService;
use App\Services\TokenService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TokenController extends Controller
{
    protected $tokenService;
    protected $luckyService;
    protected $userTokenRepository;
    protected $historyRepository;

    public function __construct(
        TokenService $tokenService,
        LuckyService $luckyService,
        UserTokenRepository $userTokenRepository,
        HistoryRepository $historyRepository
    )
    {
        $this->tokenService = $tokenService;
        $this->luckyService= $luckyService;
        $this->userTokenRepository = $userTokenRepository;
        $this->historyRepository = $historyRepository;
    }

    public function showSpecialPage(): View
    {
        return view('token.page');
    }

    public function generateNewToken(): RedirectResponse
    {
        $token = $this->userTokenRepository->create($this->tokenService->generateToken());
        return redirect()->route('special.page', ['token' => $token->token])
            ->with('success', "New token generated: {$token->token}");
    }

    public function deactivateToken(): RedirectResponse
    {
        $this->userTokenRepository->deactivate();
        Auth::logout();
        return redirect()->route('indexAction')->with('success', 'Token was deactivated');
    }

    public function imFeelingLucky(): RedirectResponse
    {
        list($user, $randomNumber, $result, $winAmount) = $this->luckyService->luckyHandler();
        return redirect()->route('special.page', ['token' => $user->userToken->token])
        ->with('success', "Random number: $randomNumber, Result: $result, Win sum: $winAmount");
    }

    public function showHistory(): View
    {
        $countRows = History::COUNT_ROWS;
        $history = $this->historyRepository->findLastElementByLimit($countRows);
        return view('token.history', compact('history', 'countRows'));
    }
}
