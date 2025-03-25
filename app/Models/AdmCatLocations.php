<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmCatLocations extends Model
{
    use HasFactory;

    protected $table = 'tbcat_locations';
    protected $primaryKey = 'id';

    protected $fillable =[
        'location',
        'category'
    ];
}
