<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cin', 
        'nom', 
        'prenom', 
        'sexe', 
        'titre', 
        'salaire',
        'email', 
        'tel', 
        'adresse', 
        'bio', 
        'image', 
        'cv', 
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function matieres() {
        return $this->hasMany(Matiere::class);
    }




    public function affichage() {
        return $this->nom();
    }

    public function nom() {
        return $this->prenom." ".$this->nom;
    }

    public function dateRejoin()
    {
        return formatDate($this->created_at);
    }
}
