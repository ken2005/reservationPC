<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $table = 'eleve';
    protected $primaryKey = 'Id_Eleve';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom'
    ];

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'etre_membre', 'Id_Eleve', 'Id_Classe');
    }

    public function ligneReservations()
    {
        return $this->hasMany(LigneReservation::class, 'Id_Eleve', 'Id_Eleve');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($eleve) {
            $eleve->nom = strtoupper($eleve->nom);
            $eleve->prenom = ucfirst(strtolower($eleve->prenom));
        });
    }
}
