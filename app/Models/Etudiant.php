<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cne', 
        'nom', 
        'prenom', 
        'sexe', 
        'date_de_naissance', 
        'email', 
        'tel', 
        'adresse', 
        'bio', 
        'image', 
        'parent_id', 
        'user_id',
        'classe_id',
    ];

    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_de_naissance' => 'datetime',
    ];



    public function user() {
        return $this->belongsTo(User::class);
    }

    public function parent() {
        return $this->belongsTo(Parentt::class, 'parent_id');
    }

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    


    public function nom() {
        return $this->prenom." ".$this->nom;
    }

    public function affichage() {
        return $this->nom();
    }

    public function dateDeNaissance()
    {
        return formatDate($this->date_de_naissance);
    }

    public function dateAdmission()
    {
        return formatDate($this->created_at);
    }
}
