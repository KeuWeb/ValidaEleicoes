<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmVoters extends Model
{
    use HasFactory;

    protected $table = 'tbvoters';
    protected $primaryKey = 'id';

    protected $fillable =[
        'fulname',
        'rg',
        'cpf',
        'other_doc',
        'email',
        'category',
        'local'
    ];

    protected $hidden = [
        'password'
    ];
}
