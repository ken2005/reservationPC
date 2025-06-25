<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emplacement', function (Blueprint $table) {
            $table->id('Id_emplacement');
            $table->string('libelle', 50);
            $table->string('details', 250);
        });

        Schema::create('pc', function (Blueprint $table) {
            $table->id('Id_PC');
            $table->string('libelle', 50);
            $table->string('serial_number', 50)->nullable();
            $table->string('marque', 50)->nullable();
            $table->string('modele', 50)->nullable();
            $table->string('type_chargeur', 50)->nullable();
            $table->boolean('disponible')->default(true);
            $table->date('date_dispo')->nullable();
            $table->foreignId('Id_emplacement')->constrained('emplacement', 'Id_emplacement');
        });

        Schema::create('eleve', function (Blueprint $table) {
            $table->id('Id_Eleve');
            $table->string('nom', 50);
            $table->string('prenom', 50);
        });

        Schema::create('classe', function (Blueprint $table) {
            $table->id('Id_Classe');
            $table->string('libelle', 50);
        });

        Schema::create('salle', function (Blueprint $table) {
            $table->id('Id_Salle');
            $table->string('libelle', 50);
        });

        Schema::create('reservation', function (Blueprint $table) {
            $table->id('Id_Reservation');
            $table->date('r_date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->foreignId('Id_Salle')->constrained('salle', 'Id_Salle');
            $table->foreignId('Id_Professeur')->constrained('professeur', 'id');
            $table->string('statut', 50)->default('En attente');
            $table->string('motif', 250)->nullable();
        });

        Schema::create('ligne_reservation', function (Blueprint $table) {
            $table->id('Id_ligne_reservation');
            $table->foreignId('Id_Reservation')->constrained('reservation', 'Id_Reservation');
            $table->foreignId('Id_PC')->constrained('pc', 'Id_PC');
            $table->foreignId('Id_Eleve')->constrained('eleve', 'Id_Eleve');
        });

        Schema::create('etre_membre', function (Blueprint $table) {
            $table->foreignId('Id_Eleve')->constrained('eleve', 'Id_Eleve');
            $table->foreignId('Id_Classe')->constrained('classe', 'Id_Classe');
            $table->primary(['Id_Eleve', 'Id_Classe']);
        });

        Schema::create('enseigner', function (Blueprint $table) {
            $table->foreignId('Id_Professeur')->constrained('professeur', 'id');
            $table->foreignId('Id_Classe')->constrained('classe', 'Id_Classe');
            $table->primary(['Id_Professeur', 'Id_Classe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseigner');
        Schema::dropIfExists('etre_membre');
        Schema::dropIfExists('ligne_reservation');
        Schema::dropIfExists('reservation');
        Schema::dropIfExists('salle');
        Schema::dropIfExists('classe');
        Schema::dropIfExists('eleve');
        Schema::dropIfExists('pc');
        Schema::dropIfExists('emplacement');
    }
};
