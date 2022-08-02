<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee',
        'niveau', 
        'nom', 
        'filiere_id',
    ];
    
    public $timestamps = false;

    
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    
    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class);
    }

    public function affichage()
    {
        return $this->niveau.' '.$this->filiere->nom.' '.$this->nom;
    }
}
