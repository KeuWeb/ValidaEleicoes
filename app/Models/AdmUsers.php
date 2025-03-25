<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmUsers extends Model
{
    use HasFactory;

    protected $table = 'tbusers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'login',
        'password',
        'level',
        'status',
        'id-user'
    ];

    protected $hidden = [
        'password'
    ];
}
