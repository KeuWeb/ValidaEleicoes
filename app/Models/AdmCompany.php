<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmCompany extends Model
{
    use HasFactory;

    protected $table = 'tbelections';
    protected $primaryKey = 'id';

    protected $fillable =[
        'company',
        'cnpj',
        'phone',
        'email',
        'responsable',
        'cep',
        'street',
        'number',
        'complement',
        'neighborhood',
        'cuty',
        'uf'
    ];
}
