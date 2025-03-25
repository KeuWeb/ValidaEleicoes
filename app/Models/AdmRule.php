<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmRule extends Model
{
    use HasFactory;

    protected $table = 'tbconfigs';
    protected $primaryKey = 'id';

    protected $fillable =[
        'access',
        'foreigner',
        'time',
        'difvotes'
    ];
}
