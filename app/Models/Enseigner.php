<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseigner extends Model
{
    //
    protected $table = 'enseigner';
    
    // Définir explicitement qu'il n'y a pas de clé primaire auto-incrémentée
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Id_Professeur',
        'Id_Classe'
    ];

    public function professeur()
    {
        return $this->belongsTo(User::class, 'Id_Professeur', 'id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'Id_Classe', 'Id_Classe');
    }

}
