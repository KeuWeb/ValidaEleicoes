<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmCandidates extends Model
{
    use HasFactory;

    protected $table = 'tbcandidates';
    protected $primaryKey = 'id';

    protected $fillable = [
        'election',
        'name',
        'ballot',
        'category',
        'local',
        'card',
        'photo',
        'curriculum',
        'status',
        'votes_indication',
        'votes_election'
    ];

    public function card()
    {
        return $this->belongsTo(AdmCards::class, 'card', 'id');
    }

    public function photoUpload()
    {
        return $this->hasOne(AdmUploads::class, 'id', 'photo'); // 'photo' é a chave estrangeira para 'id' na tabela AdmUploads
    }
}

