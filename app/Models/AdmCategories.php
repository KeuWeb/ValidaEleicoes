<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmCategories extends Model
{
    use HasFactory;

    protected $table = 'tbcategories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title'
    ];
}
