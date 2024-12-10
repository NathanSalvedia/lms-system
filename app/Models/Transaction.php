<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;
use Illuminate\Notifications\Notifiable;

class Transaction extends Model
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'user_id',
        'book_id',
        'starting_time',
        'end_time',
        'return_time',
        'status',
        'penalty',
    ];
}
