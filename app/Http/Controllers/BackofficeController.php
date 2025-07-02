<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BackofficeController extends Controller
{
    //
    public function index()
    {
        $professeurs = \App\Models\User::all();
        $eleves = \App\Models\Eleve::all();
        $classes = \App\Models\Classe::all();
        $pcs = \App\Models\PC::with('emplacement')->get();

        return view('backoffice.crud', compact('professeurs', 'eleves', 'classes', 'pcs'));
    }

    public function storeProfesseur(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:professeur,email',
            'password' => 'nullable|string|min:8',
        ]);

        if (!$request->filled('password')) {
            // Si le mot de passe n'est pas fourni, générer un mot de passe aléatoire
            $request->merge(['password' => substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10)]);
        }

        \App\Models\User::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'default_password' => $request->password, // Stocker le mot de passe en clair pour la réinitialisation
        ]);

        return redirect()->back()->with('success', 'Professeur ajouté avec succès');
    }    
    public function destroyProfesseur($id)
    {
        // Suppression des réservations et lignes associées
        $reservations = DB::table('reservation')->where('Id_Professeur', $id)->pluck('Id_Reservation');
        $nbLignesRes = 0;
        foreach ($reservations as $resId) {
            $nbLignesRes += DB::table('ligne_reservation')->where('Id_Reservation', $resId)->delete();
        }
        $nbReservations = DB::table('reservation')->where('Id_Professeur', $id)->delete();
        // Suppression des relations dans enseigner
        $enseignementsSupprimes = DB::table('enseigner')->where('Id_Professeur', $id)->count();
        DB::table('enseigner')->where('Id_Professeur', $id)->delete();
        // Suppression du professeur
        \App\Models\User::findOrFail($id)->delete();
        $message = 'Professeur supprimé avec succès.';
        if ($nbReservations > 0) {
            $message .= ' ' . $nbReservations . ' réservation(s) et ' . $nbLignesRes . ' ligne(s) de réservation supprimées.';
        }
        if ($enseignementsSupprimes > 0) {
            $message .= ' ' . $enseignementsSupprimes . ' ligne(s) supprimée(s) dans les enseignements associées à ce professeur.';
        }
        return redirect()->back()->with('success', $message);
    }

    public function storeEleve(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
        ]);

        \App\Models\Eleve::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        return redirect()->back()->with('success', 'Élève ajouté avec succès');
    }

    public function destroyEleve($id)
    {
        \App\Models\Eleve::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Élève supprimé avec succès');
    }

    public function storeClasse(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
        ]);

        \App\Models\Classe::create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->back()->with('success', 'Classe ajoutée avec succès');
    }

    public function destroyClasse($id)
    {
        \App\Models\Classe::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Classe supprimée avec succès');
    }

    public function createPC()
    {
        $emplacements = \App\Models\Emplacement::all();
        return view('backoffice.pc.create', compact('emplacements'));
    }

    public function storePC(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:50',
            'marque' => 'nullable|string|max:50',
            'modele' => 'nullable|string|max:50',
            'type_chargeur' => 'nullable|string|max:50',
            'Id_emplacement' => 'required|exists:emplacement,Id_emplacement',
        ]);

        \App\Models\PC::create($request->all());
        return redirect()->route('ordinateurs.index')->with('success', 'PC ajouté avec succès');
    }

    public function destroyPC($id)
    {
        \App\Models\PC::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'PC supprimé avec succès');
    }

    // Index methods for each section
    
    public function indexProfesseurs()
    {
        $professeurs = \App\Models\User::all();
        return view('backoffice.professeurs', compact('professeurs'));
    }

    public function indexOrdinateurs()
    {
        $pcs = \App\Models\PC::all();
        $emplacements = \App\Models\Emplacement::all();
        return view('backoffice.ordinateurs', compact('pcs', 'emplacements'));
    }        
    public function indexEleves()
    {
        $eleves = \App\Models\Eleve::all();
        return view('backoffice.eleves', compact('eleves'));
    }

    public function indexClasses()
    {
        $classes = \App\Models\Classe::all();
        return view('backoffice.classes', compact('classes'));
    }

public function indexSalles()
    {
        $salles = \App\Models\Salle::all();
        return view('backoffice.salles', compact('salles'));
    }

    public function indexEnseigner()
    {
        $enseignements = \App\Models\Enseigner::with(['professeur', 'classe'])->get();
        $professeurs = \App\Models\User::all();
        $classes = \App\Models\Classe::all();
        return view('backoffice.enseigner', compact('enseignements', 'professeurs', 'classes'));
    }

    public function indexEtreMembre()
    {
        $memberships = \App\Models\EtreMembre::with(['eleve', 'classe'])->get();
        $eleves = \App\Models\Eleve::all();
        $classes = \App\Models\Classe::all();
        return view('backoffice.etre_membre', compact('memberships', 'eleves', 'classes'));
    }

    
    public function storeSalle(Request $request)
    {
        $request->validate([
            'libelle' => 'required|max:50'
        ]);

        \App\Models\Salle::create([
            'libelle' => $request->libelle
        ]);

        return redirect()->route('salles.index')->with('success', 'Salle ajoutée avec succès');
    }

    public function destroySalle($id)
    {
        $salle = \App\Models\Salle::findOrFail($id);
        $salle->delete();

        return redirect()->route('salles.index')->with('success', 'Salle supprimée avec succès');
    }

    public function storeEtreMembre(Request $request)
    {
        $request->validate([
            'Id_Eleve' => 'required|exists:eleve,Id_Eleve',
            'Id_Classe' => 'required|exists:classe,Id_Classe'
        ]);

        \App\Models\EtreMembre::create([
            'Id_Eleve' => $request->Id_Eleve,
            'Id_Classe' => $request->Id_Classe
        ]);

        return redirect()->route('etre-membre.index')->with('success', 'Membre ajouté avec succès');
    }

    public function destroyEtreMembre($Id_Eleve, $Id_Classe)
    {
        $Id_Eleve = (int) $Id_Eleve;
        $Id_Classe = (int) $Id_Classe;
        
        DB::table('etre_membre')
            ->where('Id_Eleve', $Id_Eleve)
            ->where('Id_Classe', $Id_Classe)
            ->delete();

        return redirect()->route('etre-membre.index')->with('success', 'Membre supprimé avec succès');
    }

    public function storeEnseigner(Request $request)
    {
        $request->validate([
            'Id_Professeur' => 'required|exists:professeur,id',
            'Id_Classe' => 'required|exists:classe,Id_Classe'
        ]);

        \App\Models\Enseigner::create([
            'Id_Professeur' => $request->Id_Professeur,
            'Id_Classe' => $request->Id_Classe
        ]);

        return redirect()->route('enseigner.index')->with('success', 'Enseignement ajouté avec succès');
    }

    public function destroyEnseigner($Id_Professeur, $Id_Classe)
    {
        $Id_Professeur = (int) $Id_Professeur;
        $Id_Classe = (int) $Id_Classe;
        
        DB::table('enseigner')
            ->where('Id_Professeur', $Id_Professeur)
            ->where('Id_Classe', $Id_Classe)
            ->delete();

        return redirect()->route('enseigner.index')->with('success', 'Enseignement supprimé avec succès');
    }

    // Méthodes de modification

    public function editProfesseur($id)
    {
        $professeur = \App\Models\User::findOrFail($id);
        return view('backoffice.professeurs_edit', compact('professeur'));
    }

    public function updateProfesseur(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:professeur,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $professeur = \App\Models\User::findOrFail($id);
        $professeur->update([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $professeur->update(['password' => bcrypt($request->password)]);
            $professeur->update(['default_password' => null]); // Mettre à jour le mot de passe par défaut
        }

        return redirect()->route('professeurs.index')->with('success', 'Professeur modifié avec succès');
    }

    public function editEleve($id)
    {
        $eleve = \App\Models\Eleve::findOrFail($id);
        return view('backoffice.eleves_edit', compact('eleve'));
    }

    public function updateEleve(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
        ]);

        $eleve = \App\Models\Eleve::findOrFail($id);
        $eleve->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
        ]);

        return redirect()->route('eleves.index')->with('success', 'Élève modifié avec succès');
    }

    public function editClasse($id)
    {
        $classe = \App\Models\Classe::findOrFail($id);
        return view('backoffice.classes_edit', compact('classe'));
    }

    public function updateClasse(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
        ]);

        $classe = \App\Models\Classe::findOrFail($id);
        $classe->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('classes.index')->with('success', 'Classe modifiée avec succès');
    }

    public function editPC($id)
    {
        $pc = \App\Models\PC::findOrFail($id);
        $emplacements = \App\Models\Emplacement::all();
        return view('backoffice.ordinateurs_edit', compact('pc', 'emplacements'));
    }

    public function updatePC(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
            'serial_number' => 'nullable|string|max:50',
            'marque' => 'nullable|string|max:50',
            'modele' => 'nullable|string|max:50',
            'type_chargeur' => 'nullable|string|max:50',
            'Id_emplacement' => 'required|exists:emplacement,Id_emplacement',
        ]);

        $pc = \App\Models\PC::findOrFail($id);
        $pc->update($request->all());

        return redirect()->route('ordinateurs.index')->with('success', 'PC modifié avec succès');
    }

    public function editSalle($id)
    {
        $salle = \App\Models\Salle::findOrFail($id);
        return view('backoffice.salles_edit', compact('salle'));
    }

    public function updateSalle(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
        ]);

        $salle = \App\Models\Salle::findOrFail($id);
        $salle->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('salles.index')->with('success', 'Salle modifiée avec succès');
    }

    public function editEtreMembre($Id_Eleve, $Id_Classe)
    {
        $Id_Eleve = (int) $Id_Eleve;
        $Id_Classe = (int) $Id_Classe;
        
        $etreMembre = DB::table('etre_membre')
            ->where('Id_Eleve', $Id_Eleve)
            ->where('Id_Classe', $Id_Classe)
            ->first();
            
        if (!$etreMembre) {
            abort(404);
        }
        
        $eleves = \App\Models\Eleve::all();
        $classes = \App\Models\Classe::all();
        return view('backoffice.etre_membre_edit', compact('etreMembre', 'eleves', 'classes'));
    }

    public function updateEtreMembre(Request $request, $Id_Eleve, $Id_Classe)
    {
        $Id_Eleve = (int) $Id_Eleve;
        $Id_Classe = (int) $Id_Classe;
        
        $request->validate([
            'Id_Eleve' => 'required|exists:eleve,Id_Eleve',
            'Id_Classe' => 'required|exists:classe,Id_Classe'
        ]);

        // Supprimer l'ancienne relation
        DB::table('etre_membre')
            ->where('Id_Eleve', $Id_Eleve)
            ->where('Id_Classe', $Id_Classe)
            ->delete();

        // Créer la nouvelle relation
        DB::table('etre_membre')->insert([
            'Id_Eleve' => $request->Id_Eleve,
            'Id_Classe' => $request->Id_Classe
        ]);

        return redirect()->route('etre-membre.index')->with('success', 'Membre modifié avec succès');
    }

    public function editEnseigner($Id_Professeur, $Id_Classe)
    {
        $Id_Professeur = (int) $Id_Professeur;
        $Id_Classe = (int) $Id_Classe;
        
        $enseigner = DB::table('enseigner')
            ->where('Id_Professeur', $Id_Professeur)
            ->where('Id_Classe', $Id_Classe)
            ->first();
            
        if (!$enseigner) {
            abort(404);
        }
        
        $professeurs = \App\Models\User::all();
        $classes = \App\Models\Classe::all();
        return view('backoffice.enseigner_edit', compact('enseigner', 'professeurs', 'classes'));
    }

    public function updateEnseigner(Request $request, $Id_Professeur, $Id_Classe)
    {
        $Id_Professeur = (int) $Id_Professeur;
        $Id_Classe = (int) $Id_Classe;
        
        $request->validate([
            'Id_Professeur' => 'required|exists:professeur,id',
            'Id_Classe' => 'required|exists:classe,Id_Classe'
        ]);

        // Supprimer l'ancienne relation
        DB::table('enseigner')
            ->where('Id_Professeur', $Id_Professeur)
            ->where('Id_Classe', $Id_Classe)
            ->delete();

        // Créer la nouvelle relation
        DB::table('enseigner')->insert([
            'Id_Professeur' => $request->Id_Professeur,
            'Id_Classe' => $request->Id_Classe
        ]);

        return redirect()->route('enseigner.index')->with('success', 'Enseignement modifié avec succès');
    }
}
