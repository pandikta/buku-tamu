<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'guest_id',
        'staff_id',
        'regis_time',
        'flag_scan',
    ];
    protected $table = 'registration';
}
