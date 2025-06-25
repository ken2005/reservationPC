<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $table = 'salle';
    protected $primaryKey = 'Id_Salle';
    public $timestamps = false;
    
    protected $fillable = [
        'libelle'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'Id_Salle', 'Id_Salle');
    }
}
