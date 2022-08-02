<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeEpreuve extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'coeff', 
    ];
    
    public $timestamps = false;
    
    
    public function epreuves()
    {
        return $this->hasMany(Epreuve::class);
    }
}
