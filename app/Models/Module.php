<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 
        'classe_id',
    ];
    
    public $timestamps = false;

    
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
}
