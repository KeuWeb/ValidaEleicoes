<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmMailing extends Model
{
    use HasFactory;

    protected $table = 'tbmailings';
    protected $primaryKey = 'id';

    protected $fillable =[
        'type',
        'title',
        'txt'
    ];
}
