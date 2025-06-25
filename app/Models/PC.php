<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PC extends Model
{
    protected $table = 'pc';
    protected $primaryKey = 'Id_PC';
    public $timestamps = false;

    protected $fillable = [
        'libelle',
        'serial_number',
        'marque',
        'modele',
        'type_chargeur',
        'disponible',
        'date_dispo',
        'Id_emplacement'
    ];

    public function ligneReservations()
    {
        return $this->hasMany(LigneReservation::class, 'Id_PC', 'Id_PC');
    }

    public function emplacement()
    {
        return $this->belongsTo(Emplacement::class, 'Id_emplacement', 'Id_emplacement');
    }
}
