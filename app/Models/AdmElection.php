<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmElection extends Model
{
    use HasFactory;

    protected $table = 'tbelections';
    protected $primaryKey = 'id';

    protected $fillable =[
        'titleInd',
        'dateIniInd',
        'dateEndInd',
        'titleEle',
        'dateIniEle',
        'dateEndEle',
        'dateInvEle'
    ];
}
