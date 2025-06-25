<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtreMembre extends Model
{
    //
    protected $table = 'etre_membre';
    public $timestamps = false;
    public $incrementing = false;
    // Définir explicitement qu'il n'y a pas de clé primaire auto-incrémentée
    protected $primaryKey = null;
    protected $fillable = ['Id_Eleve', 'Id_Classe'];
    
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'Id_Eleve', 'Id_Eleve');
    }
    
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'Id_Classe', 'Id_Classe');
    }
    
}
