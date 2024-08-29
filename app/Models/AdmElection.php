<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmElection extends Model
{
    use HasFactory;

    protected $table = 'tbelection';
    protected $primaryKey = 'id';

    protected $fillable =[
        'date-str-ele',
        'date-end-ele',
        'date-inv-ele',
        'date-str-ind',
        'date-end-ind',
        'title',
        'cnpj',
        'responsable',
        'company',
        'email'
    ];
}
