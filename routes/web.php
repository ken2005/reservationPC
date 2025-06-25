<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PcController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Illuminate\Support\Facades\DB;


Route::get('/', [App\Http\Controllers\ReservationController::class, 'index'])->name('reservation');
Route::post('/reservation', [App\Http\Controllers\ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/{id}', [App\Http\Controllers\ReservationController::class, 'show']);
Route::delete('/reservation/{id}', [App\Http\Controllers\ReservationController::class, 'destroy'])->name('reservation.destroy');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.signup');
})->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/test', function () {
    return view('test');
});

Route::get('/reservations/listing', [App\Http\Controllers\ReservationController::class, 'listing'])->name('reservations.listing');
Route::post('/reservation/refuse', [App\Http\Controllers\ReservationController::class, 'refuseReservation'])->name('reservation.refuse');
Route::post('/reservation/validate', [App\Http\Controllers\ReservationController::class, 'validateReservation'])->name('reservation.validate');

Route::post('/send-validation-email', [MailController::class, 'sendValidationEmail']);
Route::post('/send-refus-email', [MailController::class, 'sendRefusEmail']);


Route::get('/pc-dispos', function() {
    return view('pc-dispos');
})->name('pc-dispos');

Route::get('/student-list', function() {
    return view('student-list');
})->name('student-list');
Route::get('/reservations/listing-valide', [App\Http\Controllers\ReservationController::class, 'listingValide'])->name('reservations.listing-valide');


Route::get('/livewire/livewire.js', function () {
    return Livewire::getScriptResponse();
});

// Routes protégées pour l'admin
Route::middleware(['auth', 'admin'])->group(function () {
    //test backoffice
    Route::get('/backoffice/crud', function () {
        $professeurs = DB::table('professeur')->get();
        $eleves = DB::table('eleve')->get();
        $classes = DB::table('classe')->get();
        $pcs = DB::table('pc')->get();
        
        return view('backoffice.crud', compact('professeurs', 'eleves', 'classes', 'pcs'));
    })->name('backoffice.crud');

    Route::post('/professeur', function (Request $request) {
        DB::table('professeur')->insert(['name' => $request->nom]);
        return redirect()->route('backoffice.crud');
    })->name('professeur.store');

    Route::delete('/professeur/{id}', function ($id) {
        DB::table('professeur')->where('id', $id)->delete();
        return redirect()->route('backoffice.crud');
    })->name('professeur.destroy');

    Route::post('/eleve', function (Request $request) {
        DB::table('eleve')->insert([
            'nom' => $request->nom,
            'prenom' => $request->prenom
        ]);
        return redirect()->route('backoffice.crud');
    })->name('eleve.store');

    Route::delete('/eleve/{id}', function ($id) {
        DB::table('eleve')->where('Id_Eleve', $id)->delete();
        return redirect()->route('backoffice.crud');
    })->name('eleve.destroy');

    Route::post('/classe', function (Request $request) {
        DB::table('classe')->insert(['libelle' => $request->libelle]);
        return redirect()->route('backoffice.crud');
    })->name('classe.store');

    Route::delete('/classe/{id}', function ($id) {
        DB::table('classe')->where('Id_Classe', $id)->delete();
        return redirect()->route('backoffice.crud');
    })->name('classe.destroy');

    Route::delete('/pc/{id}', function ($id) {
        DB::table('pc')->where('Id_PC', $id)->delete();
        return redirect()->route('backoffice.crud');
    })->name('pc.destroy');

    Route::view('/backoffice',  'backoffice.accueil')->name('backoffice.pc.index');

    Route::get('backoffice/professeurs', [App\Http\Controllers\BackofficeController::class, 'indexProfesseurs'])->name('professeurs.index');
    Route::get('backoffice/ordinateurs', [App\Http\Controllers\BackofficeController::class, 'indexOrdinateurs'])->name('ordinateurs.index');
    Route::get('backoffice/eleves', [App\Http\Controllers\BackofficeController::class, 'indexEleves'])->name('eleves.index');
    Route::get('backoffice/classes', [App\Http\Controllers\BackofficeController::class, 'indexClasses'])->name('classes.index');
    Route::get('backoffice/salles', [App\Http\Controllers\BackofficeController::class, 'indexSalles'])->name('salles.index');
    Route::get('backoffice/enseigner', [App\Http\Controllers\BackofficeController::class, 'indexEnseigner'])->name('enseigner.index');
    Route::get('backoffice/etre-membre', [App\Http\Controllers\BackofficeController::class, 'indexEtreMembre'])->name('etre-membre.index');
    Route::post('/backoffice/etre-membre', [App\Http\Controllers\BackofficeController::class, 'storeEtreMembre'])->name('backoffice.etre-membre.store');
    Route::delete('/backoffice/etre-membre/{Id_Eleve}/{Id_Classe}', [App\Http\Controllers\BackofficeController::class, 'destroyEtreMembre'])->name('backoffice.etre-membre.destroy');
    Route::post('/backoffice/enseigner', [App\Http\Controllers\BackofficeController::class, 'storeEnseigner'])->name('backoffice.enseigner.store');
    Route::delete('/backoffice/enseigner/{Id_Professeur}/{Id_Classe}', [App\Http\Controllers\BackofficeController::class, 'destroyEnseigner'])->name('backoffice.enseigner.destroy');
    Route::post('/backoffice/professeur', [App\Http\Controllers\BackofficeController::class, 'storeProfesseur'])->name('backoffice.professeur.store');
    Route::delete('/backoffice/professeur/{id}', [App\Http\Controllers\BackofficeController::class, 'destroyProfesseur'])->name('backoffice.professeur.destroy');
    Route::post('/backoffice/eleve', [App\Http\Controllers\BackofficeController::class, 'storeEleve'])->name('backoffice.eleve.store');
    Route::delete('/backoffice/eleve/{id}', [App\Http\Controllers\BackofficeController::class, 'destroyEleve'])->name('backoffice.eleve.destroy');
    Route::post('/backoffice/classe', [App\Http\Controllers\BackofficeController::class, 'storeClasse'])->name('backoffice.classe.store');
    Route::delete('/backoffice/classe/{id}', [App\Http\Controllers\BackofficeController::class, 'destroyClasse'])->name('backoffice.classe.destroy');
    Route::get('/backoffice/pc/create', [App\Http\Controllers\BackofficeController::class, 'createPC'])->name('backoffice.pc.create');
    Route::post('/backoffice/pc', [App\Http\Controllers\BackofficeController::class, 'storePC'])->name('backoffice.pc.store');
    Route::delete('/backoffice/pc/{id}', [App\Http\Controllers\BackofficeController::class, 'destroyPC'])->name('backoffice.pc.destroy');
    Route::post('/backoffice/salle', [App\Http\Controllers\BackofficeController::class, 'storeSalle'])->name('backoffice.salle.store');
    Route::delete('/backoffice/salle/{id}', [App\Http\Controllers\BackofficeController::class, 'destroySalle'])->name('backoffice.salle.destroy');

    Route::post('/import/professeurs', [App\Http\Controllers\CsvController::class, 'importProfesseurs'])->name('import.professeurs');
    Route::post('/import/eleves', [App\Http\Controllers\CsvController::class, 'importEleves'])->name('import.eleves');
    Route::post('/import/classes', [App\Http\Controllers\CsvController::class, 'importClasses'])->name('import.classes');
    Route::post('/import/pcs', [App\Http\Controllers\CsvController::class, 'importPCs'])->name('import.pcs');
    Route::post('/import/salles', [App\Http\Controllers\CsvController::class, 'importSalles'])->name('import.salles');
    Route::post('/import/etre-membre', [App\Http\Controllers\CsvController::class, 'importEtreMembre'])->name('import.etre-membre');
    Route::post('/import/enseigner', [App\Http\Controllers\CsvController::class, 'importEnseigner'])->name('import.enseigner');

    // Routes d'export CSV
    Route::get('/export/professeurs', [App\Http\Controllers\CsvController::class, 'exportProfesseurs'])->name('export.professeurs');
    Route::get('/export/eleves', [App\Http\Controllers\CsvController::class, 'exportEleves'])->name('export.eleves');
    Route::get('/export/classes', [App\Http\Controllers\CsvController::class, 'exportClasses'])->name('export.classes');
    Route::get('/export/pcs', [App\Http\Controllers\CsvController::class, 'exportPCs'])->name('export.pcs');
    Route::get('/export/salles', [App\Http\Controllers\CsvController::class, 'exportSalles'])->name('export.salles');
    Route::get('/export/etre-membre', [App\Http\Controllers\CsvController::class, 'exportEtreMembre'])->name('export.etremembre');
    Route::get('/export/enseigner', [App\Http\Controllers\CsvController::class, 'exportEnseigner'])->name('export.enseigner');

    // Routes de modification
    Route::get('/backoffice/professeur/{id}/edit', [App\Http\Controllers\BackofficeController::class, 'editProfesseur'])->name('backoffice.professeur.edit');
    Route::put('/backoffice/professeur/{id}', [App\Http\Controllers\BackofficeController::class, 'updateProfesseur'])->name('backoffice.professeur.update');
    Route::get('/backoffice/eleve/{id}/edit', [App\Http\Controllers\BackofficeController::class, 'editEleve'])->name('backoffice.eleve.edit');
    Route::put('/backoffice/eleve/{id}', [App\Http\Controllers\BackofficeController::class, 'updateEleve'])->name('backoffice.eleve.update');
    Route::get('/backoffice/classe/{id}/edit', [App\Http\Controllers\BackofficeController::class, 'editClasse'])->name('backoffice.classe.edit');
    Route::put('/backoffice/classe/{id}', [App\Http\Controllers\BackofficeController::class, 'updateClasse'])->name('backoffice.classe.update');
    Route::get('/backoffice/pc/{id}/edit', [App\Http\Controllers\BackofficeController::class, 'editPC'])->name('backoffice.pc.edit');
    Route::put('/backoffice/pc/{id}', [App\Http\Controllers\BackofficeController::class, 'updatePC'])->name('backoffice.pc.update');
    Route::get('/backoffice/salle/{id}/edit', [App\Http\Controllers\BackofficeController::class, 'editSalle'])->name('backoffice.salle.edit');
    Route::put('/backoffice/salle/{id}', [App\Http\Controllers\BackofficeController::class, 'updateSalle'])->name('backoffice.salle.update');
    Route::get('/backoffice/etre-membre/{Id_Eleve}/{Id_Classe}/edit', [App\Http\Controllers\BackofficeController::class, 'editEtreMembre'])->name('backoffice.etre-membre.edit');
    Route::put('/backoffice/etre-membre/{Id_Eleve}/{Id_Classe}', [App\Http\Controllers\BackofficeController::class, 'updateEtreMembre'])->name('backoffice.etre-membre.update');
    Route::get('/backoffice/enseigner/{Id_Professeur}/{Id_Classe}/edit', [App\Http\Controllers\BackofficeController::class, 'editEnseigner'])->name('backoffice.enseigner.edit');
    Route::put('/backoffice/enseigner/{Id_Professeur}/{Id_Classe}', [App\Http\Controllers\BackofficeController::class, 'updateEnseigner'])->name('backoffice.enseigner.update');
});

//test setmdp
Route::get('/setpassword', function () {
    return view('auth.setpassword');
})->name('setpassword');

Route::post('/setpassword', function (Request $request) {
    // Validation des données
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    return redirect()->back()->with('status', 'Mot de passe modifié avec succès');
})->name('setpassword.update');

Route::get('/pc', [App\Http\Controllers\PcController::class, 'index'])->name('pc.index');
Route::put('/pc/toggle/{id}', [PcController::class, 'toggleAvailability'])->name('pc.toggle-availability');

Route::get('/test-mail-validation', function () {
    $reservation = DB::table('reservation')
        ->join('salle', 'reservation.Id_Salle', '=', 'salle.Id_Salle')
        ->select('reservation.*', 'salle.libelle as salle_libelle')
        ->first();
    
    $ligneReservations = DB::table('ligne_reservation')
        ->join('eleve', 'ligne_reservation.Id_Eleve', '=', 'eleve.Id_Eleve')
        ->join('pc', 'ligne_reservation.Id_PC', '=', 'pc.Id_PC')
        ->join('emplacement', 'pc.Id_emplacement', '=', 'emplacement.Id_emplacement')
        ->select('ligne_reservation.*', 'eleve.nom', 'eleve.prenom', 'pc.libelle', 'emplacement.Libelle as emplacement_libelle', 'emplacement.details as emplacement_details')
        ->limit(4)
        ->get();

    return view('mail.validation', compact('reservation', 'ligneReservations'));
});

Route::get('/pc/create', [App\Http\Controllers\PcController::class, 'create'])->name('pc.create');
Route::post('/pc/store', [App\Http\Controllers\PcController::class, 'store'])->name('pc.store');