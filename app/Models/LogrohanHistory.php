<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogrohanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'side',
        'order_index',
        'user_id',
    ];
}
