<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'coef', 
        'module_id',
        'enseignant_id',
    ];
    
    public $timestamps = false;

    
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }
}
