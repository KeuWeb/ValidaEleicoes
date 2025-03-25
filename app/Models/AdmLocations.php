<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmLocations extends Model
{
    use HasFactory;

    protected $table = 'tblocations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category',
        'local'
    ];
}
