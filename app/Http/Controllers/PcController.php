<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PcController extends Controller
{
    //
    
        public function index()
        {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (!Auth::user()->id == 1) {
                return redirect()->route('login');
            }
            $pcs = \App\Models\PC::all();
            return view('pc.listing', compact('pcs'));
        }
    
        public function toggleAvailability(Request $request, $id)
        {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (!Auth::user()->id == 1) {
                return redirect()->route('login');
            }
            $pc = \App\Models\PC::findOrFail($id);
            
            $pc->disponible = !$pc->disponible;
            
            if (!$pc->disponible) {
                $pc->date_dispo = $request->date_dispo;
            } else {
                $pc->date_dispo = null;
            }
            
            $pc->save();
            
            return redirect()->route('pc.index')
                ->with('success', $pc->disponible ? 
                    'PC remis à disposition avec succès.' : 
                    'PC marqué comme indisponible avec succès.');
        }

        public function create(){
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (!Auth::user()->id == 1) {
                return redirect()->route('login');
            }
            $emplacements = \App\Models\Emplacement::all();
            return view('pc.create', compact('emplacements'));
        }

        
        public function store(Request $request)
        {
            if (!Auth::check()) {
                return redirect()->route('login');
            }
            if (!Auth::user()->id == 1) {
                return redirect()->route('login');
            }

            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'emplacement_id' => 'required|exists:emplacement,Id_emplacement',
            ]);

            $pc = new \App\Models\PC();
            $pc->libelle = $validated['nom'];
            $pc->Id_emplacement = $validated['emplacement_id'];
            $pc->disponible = true;
            $pc->save();

            return redirect()->route('pc.index')
                ->with('success', 'PC ajouté avec succès.');
        }
        
    
}
