<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothLogin extends Model
{
    use HasFactory;

    protected $table = 'tbvoters';
    protected $primaryKey = 'id';

    protected $fillable =[
        'password'
    ];

    protected $hidden = [
        'password'
    ];
}
