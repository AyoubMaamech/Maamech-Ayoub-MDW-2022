<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'note', 
        'epreuve_id',
        'etudiant_id'
    ];
    
    public $timestamps = false;

    
    public function epreuve()
    {
        return $this->belongsTo(Epreuve::class);
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }
}
