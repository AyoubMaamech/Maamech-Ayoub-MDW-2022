<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'pour',
        'date_paiement', 
        'montant', 
        'etudiant_id',
        'enseignant_id',
    ];
    
    public $timestamps = false;


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_paiement' => 'datetime',
    ];
    

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    

    public function datePaiement()
    {
        return formatDate($this->date_paiement);
    }
}
