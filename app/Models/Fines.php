<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Notifications\Notifiable;

class Fines extends Model
{

    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'fines',
    ];


    public function user() {
        return $this->belongsTo(User::class);
    }
}
