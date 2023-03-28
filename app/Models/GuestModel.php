<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'id_card_number',
        'no_hp',
        'email',
        'flag_verif',
    ];
    protected $table = 'guest';
}
