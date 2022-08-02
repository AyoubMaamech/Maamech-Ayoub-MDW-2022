<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Epreuve extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_epreuve_id',
        'matiere_id',
        'date_epreuve', 
        'salle'
    ];
    
    public $timestamps = false;


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_epreuve' => 'datetime',
    ];

    
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    
    public function type_epreuve()
    {
        return $this->belongsTo(TypeEpreuve::class);
    }

    

    public function dateEpreuve()
    {
        return formatDate($this->date_epreuve);
    }

    public function affichage()
    {
        return $this->type_epreuve->nom.' - '.$this->matiere->nom.' ( '.$this->dateEpreuve().' )';
    }
}
