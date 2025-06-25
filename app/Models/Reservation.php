<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $primaryKey = 'Id_Reservation';
    public $timestamps = false;
    
    protected $fillable = [
        'r_date',
        'heure_debut',
        'heure_fin',
        'Id_Salle',
        'Id_Professeur',
        'statut',
        'motif'
    ];

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'Id_Salle', 'Id_Salle');
    }

    public function professeur()
    {
        return $this->belongsTo(User::class, 'Id_Professeur', 'id');
    }

    public function ligneReservations()
    {
        return $this->hasMany(LigneReservation::class, 'Id_Reservation', 'Id_Reservation');
    }
}
