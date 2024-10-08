<?php

namespace App\Services;

use App\Models\History;
use App\Repositories\HistoryRepository;
use Illuminate\Support\Facades\Auth;

class LuckyService
{
    protected const NUMBER_RANGE_FROM = 1;
    protected const NUMBER_RANGE_TO = 1000;
    protected $historyRepository;

    public function __construct(HistoryRepository $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    public function luckyHandler()
    {
        $user = Auth::user();
        $randomNumber = $this->generateNumber();
        list($result, $resultToView, $winAmount) = $this->checkWin($randomNumber);

        $this->historyRepository->create([
            'user_id' => $user->id,
            'random_number' => $randomNumber,
            'result' => $result,
            'win_amount' => $winAmount,
        ]);

        return [$user, $randomNumber, $resultToView, $winAmount];

    }

    private function generateNumber()
    {
        /**
         *  some logic for generate number
         */

        return rand(self::NUMBER_RANGE_FROM, self::NUMBER_RANGE_TO);
    }
    private function checkWin(int $randomNumber) : array
    {
        /**
         * some  logic for check win or lose
         */

        $result = $randomNumber % 2 === 0 ? History::WIN : History::LOSE;
        $resultToView = $result ? History::WIN_TEXT : History::LOSE_TEXT;
        $winAmount = 0;

        if ($result === History::WIN) {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        return [$result, $resultToView, $winAmount];
    }
}
