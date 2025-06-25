<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emplacement extends Model
{
    protected $table = 'emplacement';
    protected $primaryKey = 'Id_emplacement';
    public $timestamps = false;
    
    protected $fillable = [
        'libelle',
        'details'
    ];

    public function pcs()
    {
        return $this->hasMany(Pc::class, 'Id_emplacement', 'Id_emplacement');
    }
}
