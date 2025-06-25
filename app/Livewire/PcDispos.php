<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PcDispos extends Component
{
    public $r_date;
    public $heure_debut;
    public $heure_fin;
    public $pcDispos = 0;
    public function updatePCDispos(){
        if ($this->heure_debut != null && $this->heure_fin != null && $this->r_date!= null) {
            $this->pcDispos = DB::select(query: "SELECT count(*) as nb FROM `pc` WHERE (disponible = 1 OR date_dispo <= '".$this->r_date."') AND Id_PC NOT IN(SELECT DISTINCT Id_PC FROM `ligne_reservation` INNER JOIN reservation ON ligne_reservation.Id_Reservation = reservation.Id_Reservation WHERE reservation.r_date = '".$this->r_date."' AND reservation.statut != 'Refusée'
            AND((reservation.heure_debut<= '".$this->heure_debut."' AND reservation.heure_fin >= '".$this->heure_debut."') OR (reservation.heure_debut<= '".$this->heure_fin."' AND reservation.heure_fin >= '".$this->heure_debut."')));")[0]->nb;

            /*
            $this->pcDispos = DB::table('pc')
                ->leftJoin('ligne_reservation', 'pc.Id_PC', '=', 'ligne_reservation.Id_PC')
                ->leftJoin('reservation', 'ligne_reservation.Id_Reservation', '=', 'reservation.Id_Reservation')
                ->where(function($query) {
                    $query->whereNull('ligne_reservation.Id_PC')
                        ->orWhere(function($q) {
                            $q->where('reservation.r_date', '!=', $this->r_date)
                                ->orWhere('reservation.heure_debut', '>=', $this->heure_fin)
                                ->orWhere('reservation.heure_fin', '<=', $this->heure_debut);
                        });
                })
                //->whereNull('ligne_reservation.Id_PC')
                ->select('pc.*')
                ->distinct()
                ->get();
*/
                //dd($this->pcDispos);
            }
    }

    public function render()
    {
        return view('livewire.pc-dispos');
    }
}
