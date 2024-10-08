<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    public const WIN = true;
    public const LOSE = false;

    public const WIN_TEXT = 'win';
    public const LOSE_TEXT = 'lose';

    public const COUNT_ROWS = 3;

    protected $fillable = ['user_id', 'random_number', 'result', 'win_amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
