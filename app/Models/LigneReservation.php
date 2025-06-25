<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneReservation extends Model
{
    protected $table = 'ligne_reservation';
    protected $primaryKey = 'Id_ligne_reservation';
    public $timestamps = false;

    protected $fillable = [
        'Id_Reservation',
        'Id_PC',
        'Id_Eleve'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'Id_Reservation', 'Id_Reservation');
    }

    public function pc()
    {
        return $this->belongsTo(PC::class, 'Id_PC', 'Id_PC');
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'Id_Eleve', 'Id_Eleve');
    }
}
