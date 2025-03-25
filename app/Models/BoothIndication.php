<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoothIndication extends Model
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
        'votes'
    ];

    public function card()
    {
        return $this->belongsTo(AdmCards::class, 'card', 'id');
    }

// Modelo BoothIndication
public function candidate()
{
    return $this->belongsTo(AdmCandidates::class, 'candidate_id', 'id'); // Certifique-se de que o campo candidate_id é a chave estrangeira
}


    public function photoUpload()
    {
        return $this->candidate->photoUpload();
    }
}
