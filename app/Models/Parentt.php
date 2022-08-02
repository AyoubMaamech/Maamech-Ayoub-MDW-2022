<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentt extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnp', 
        'nom', 
        'prenom', 
        'sexe', 
        'occupation', 
        'email', 
        'tel', 
        'adresse', 
        'bio', 
        'image', 
        'user_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function etudiants() {
        return $this->hasMany(Etudiant::class, 'parent_id');
    }

    public function nom() {
        return $this->prenom." ".$this->nom;
    }
}
