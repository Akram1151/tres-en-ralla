<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_x',
        'player_o',
        'board',
        'turn',
        'winner',
        'is_draw',
    ];

    protected $casts = [
        'board' => 'array',
        'is_draw' => 'boolean',
    ];
}
