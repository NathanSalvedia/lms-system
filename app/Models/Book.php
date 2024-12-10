<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Transaction;

class Book extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'edition',
        'publishYear',
        'image',
        'quantity',
        'status',
    ];


    public function transaction() {
        return $this->hasMany(Transaction::class);
    }
}
