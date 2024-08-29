<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmCommunication extends Model
{
    use HasFactory;

    protected $table = 'tbconfigs';
    protected $primaryKey = 'id';

    protected $fillable =[
        'whatsapp',
        'txt_whatsapp',
        'txt_welcome',
        'txt_finish',
        'txt_message',
        'type_voter',
        'title_email',
        'txt_email'
    ];
}
