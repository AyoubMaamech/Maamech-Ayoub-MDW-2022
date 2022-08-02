<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_seance', 
        'present',
        'seance_id',
        'etudiant_id'
    ];
    
    public $timestamps = false;


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_seance' => 'datetime',
    ];

    
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function dateSeance()
    {
        return getDays()[$this->seance->jour].' ('.formatDate($this->date_seance).') '.__('from').' '.$this->seance->de.' '.__('to').' '.$this->seance->a;
    }
}
