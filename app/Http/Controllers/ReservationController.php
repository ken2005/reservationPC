<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MailController;

class ReservationController extends Controller
{
    //
    public function index()
        {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (Auth::user()->id == '1') {
                return redirect()->route('reservations.listing');
            }
            $salles = DB::table('salle')->get();
            
            return view('reservation', compact('salles'));
        }
    
        public function store(Request $request)
        {
            $pc_dispos = DB::select("SELECT * FROM `pc` WHERE (disponible = 1 OR date_dispo <= '".$request->r_date."') AND Id_PC NOT IN(SELECT DISTINCT Id_PC FROM `ligne_reservation` INNER JOIN reservation ON ligne_reservation.Id_Reservation = reservation.Id_Reservation WHERE reservation.r_date = '".$request->r_date."' AND reservation.statut != 'Refusée' AND ((reservation.heure_debut<= '".$request->heure_debut."' AND reservation.heure_fin >= '".$request->heure_debut."') OR (reservation.heure_debut<= '".$request->heure_fin."' AND reservation.heure_fin >= '".$request->heure_debut."')));");
            //dd($request);
            //dd($pc_dispos);
            if (count($pc_dispos) < count($request->eleve)) {
                return redirect()->back()->with('error', 'pas assez de PC disponibles pour ce créneau');
            }
            
            $id = DB::table('reservation')->insertGetId([
                'r_date' => $request->r_date,
                'heure_debut' => $request->heure_debut,
                'heure_fin' => $request->heure_fin,
                'Id_Salle' => $request->Id_Salle,
                'Id_Professeur' => Auth::user()->id
            ]);



            $pcIds = DB::table('pc')
                ->leftJoin('ligne_reservation', 'pc.Id_PC', '=', 'ligne_reservation.Id_PC')
                ->join('reservation', 'ligne_reservation.Id_Reservation', '=', 'reservation.Id_Reservation')
                ->where(function($query) use ($request) {
                    $query->whereNull('ligne_reservation.Id_PC')
                        ->orWhere(function($q) use ($request) {
                            $q->where('reservation.r_date', '!=', $request->r_date)
                                ->orWhere('reservation.heure_debut', '>=', $request->heure_fin)
                                ->orWhere('reservation.heure_fin', '<=', $request->heure_debut);
                        });
                })
                ->orderBy('pc.Id_emplacement')
                ->limit(count($request->eleve))
                ->pluck('pc.Id_PC');

            foreach($request->eleve as $key => $eleve) {
                DB::table('ligne_reservation')->insert([
                    'Id_Reservation' => $id,
                    'Id_Eleve' => $eleve,
                    'Id_PC' => $pc_dispos[$key]->Id_PC
                ]);
            }
    
            return redirect()->route('reservation')->with('success', 'Réservation créée avec succès');
            //return response()->json(['message' => 'Réservation créée avec succès']);
        }
    
        public function show($id)
        {
            $reservation = DB::table('reservation')
                ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                ->join('ligne_reservation', 'reservation.Id_Reservation', '=', 'ligne_reservation.Id_Reservation')
                ->where('reservation.Id_Reservation', $id)
                ->first();
            
            if (!$reservation) {
                abort(404);
            }
            
            
            return response()->json($reservation);
        }
    
        public function destroy($id)
        {
            DB::table('ligne_reservation')->where('Id_Reservation', $id)->delete();
            DB::table('reservation')->where('Id_Reservation', $id)->delete();
            return redirect()->route('reservation')->with('success', 'Réservation supprimée avec succès');
        }

        
                public function listing()
                {
                    if (Auth::user()->id == 1) {
                        $reservations = DB::table('reservation')
                            ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                            ->join('ligne_reservation', 'reservation.Id_Reservation', '=', 'ligne_reservation.Id_Reservation')
                            ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
                            ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
                            ->where('statut', '=', 'En attente')
                            ->select('reservation.*', 'salle.Libelle', 'ligne_reservation.Id_PC', 'eleve.nom', 'eleve.prenom','pc.libelle as pc_libelle')
                            ->orderBy('reservation.r_date', 'desc')
                            ->orderBy('reservation.heure_debut', 'asc')
                            ->get();
                    }
                    else {
                        $reservations = DB::table('reservation')
                            ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                            ->join('ligne_reservation', 'reservation.Id_Reservation', '=', 'ligne_reservation.Id_Reservation')
                            ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
                            ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
                            ->where('reservation.Id_Professeur', Auth::user()->id)
                            ->where('statut', '=', 'En attente')
                            ->select('reservation.*', 'salle.Libelle', 'ligne_reservation.Id_PC', 'eleve.nom', 'eleve.prenom','pc.libelle as pc_libelle')
                            ->orderBy('reservation.r_date', 'desc')
                            ->orderBy('reservation.heure_debut', 'asc')
                            ->get();
                    }
        
                    return view('reservations.listing', compact('reservations'));
                }

                public function listingValide()
                {
                    if (Auth::user()->id == 1) {
                        $reservations = DB::table('reservation')
                            ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                            ->join('ligne_reservation', 'reservation.Id_Reservation', '=', 'ligne_reservation.Id_Reservation')
                            ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
                            ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
                            ->where('statut', '=', 'Validée')
                            ->select('reservation.*', 'salle.Libelle', 'ligne_reservation.Id_PC', 'eleve.nom', 'eleve.prenom', 'pc.libelle as pc_libelle')
                            ->orderBy('reservation.r_date', 'desc')
                            ->orderBy('reservation.heure_debut', 'asc')
                            ->get();
                    }
                    else {
                        $reservations = DB::table('reservation')
                            ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                            ->join('ligne_reservation', 'reservation.Id_Reservation', '=', 'ligne_reservation.Id_Reservation')
                            ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
                            ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
                            ->where('reservation.Id_Professeur', Auth::user()->id)
                            ->where('statut', '=', 'Validée')
                            ->select('reservation.*', 'salle.Libelle', 'ligne_reservation.Id_PC', 'eleve.nom', 'eleve.prenom', 'pc.libelle as pc_libelle')
                            ->orderBy('reservation.r_date', 'desc')
                            ->orderBy('reservation.heure_debut', 'asc')
                            ->get();
                    }
        
                    return view('reservations.listing', compact('reservations'));
                }

        public function refuseReservation(Request $request)
        {
            $reservationId = $request->input('reservationId');
            $reason = $request->input('reason');
        
            DB::table('reservation')
                ->where('Id_Reservation', $reservationId)
                ->update([
                    'statut' => 'Refusée',
                    'motif' => $reason
                ]);

            $reservation = DB::table('reservation')
                ->join('professeur', 'reservation.Id_Professeur', '=', 'professeur.id')
                ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                ->where('Id_Reservation', $reservationId)
                ->select('reservation.*', 'salle.Libelle as  salle_libelle','professeur.email as email')
                ->first();

            $mailController = new MailController();
            $mailController->sendRefusEmail($reservation->email, $reason, $reservation);
        
            return redirect()->route('reservations.listing')->with('success', 'Réservation refusée avec succès');
        }

        public function validateReservation(Request $request)
            {
                $reservationId = $request->input('reservationId');
        
                DB::table('reservation')
                    ->where('Id_Reservation', $reservationId)
                    ->update([
                        'statut' => 'Validée'
                    ]);
        
                $reservation = DB::table('reservation')
                    ->join('professeur', 'reservation.Id_Professeur', '=', 'professeur.id')
                    ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
                    ->where('Id_Reservation', $reservationId)
                    ->select('reservation.*', 'salle.Libelle as  salle_libelle','professeur.email as email')
                    ->first();

                    $ligneReservations = DB::table('ligne_reservation')
                    ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
                    ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
                    ->join('emplacement', 'pc.Id_emplacement', '=', 'emplacement.Id_emplacement')
                    ->where('Id_Reservation', $reservationId)
                    ->select('ligne_reservation.*', 'eleve.nom', 'eleve.prenom', 'pc.libelle', 'emplacement.Libelle as emplacement_libelle', 'emplacement.details as emplacement_details')
                    ->get();
                    //dd($ligneReservations);
                $mailController = new MailController();
                $mailController->sendValidationEmail($reservation->email, $reservation, $ligneReservations);

                //$autresReservations = DB::table('reservation')->where('Id_Reservation','!=',$reservationId)->where()
        
                return redirect()->route('reservations.listing')->with('success', 'Réservation validée avec succès');
            }
        
        
        
    
}
