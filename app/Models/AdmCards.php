<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdmTbLocation;

class AdmCards extends Model
{
    use HasFactory;

    protected $table = 'tbcards';
    protected $primaryKey = 'id';

    public function location()
    {
        return $this->belongsTo(AdmTbLocation::class, 'local', 'id');
    }

    protected $fillable = [
        'title',
        'order',
        'limit_votes',
        'category',
        'local',
        'status'
    ];

    public function candidates()
    {
        return $this->hasMany(AdmCandidates::class, 'card', 'id')->where(
            'status', 1
        )->where(
            'type', 1
        )->orderBy(
            'votes_election', 'DESC'
        );
    }
}
