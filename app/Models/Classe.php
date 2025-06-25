<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classe';
    protected $primaryKey = 'Id_Classe';
    public $timestamps = false;
    protected $fillable = ['libelle'];

    public function eleves()
    {
        return $this->belongsToMany(Eleve::class, 'etre_membre', 'Id_Classe', 'Id_Eleve');
    }

    public function professeurs()
    {
        return $this->belongsToMany(User::class, 'enseigner', 'Id_Classe', 'Id_Professeur');
    }
}
