<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmUploads extends Model
{
    use HasFactory;

    protected $table = 'tbuploads';
    protected $primaryKey = 'id';

    protected $fillable =[
        'type',
        'name',
        'link'
    ];
}
