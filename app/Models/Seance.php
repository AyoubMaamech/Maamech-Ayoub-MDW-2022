<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'jour', 
        'de', 
        'a', 
        'salle',
        'matiere_id',
    ];
    
    public $timestamps = false;

    
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function affichage()
    {
        return getDays()[$this->jour].' '.__('from').' '.$this->de.' '.__('to').' '.$this->a;
    }
}
