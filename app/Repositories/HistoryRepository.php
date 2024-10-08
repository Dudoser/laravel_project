<?php

namespace App\Repositories;

use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class HistoryRepository
{
    public function create(array $data): History
    {
        return History::create($data);
    }

    public function findLastElementByLimit(int $limit): Collection
    {
        $user = Auth::user();
        return $user->histories()->latest()->take($limit)->get();
    }

}
