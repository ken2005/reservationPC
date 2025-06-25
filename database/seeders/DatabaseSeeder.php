<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('professeur')->insert([
            ['id' => 1, 'name' => 'ADMIN', 'prenom' => 'John', 'email' => 'admin@example.com', 'password' => bcrypt('password')],
        ]);

        DB::table('emplacement')->insert([
            ['Id_emplacement' => 1, 'libelle' => 'Bureau informatique', 'details' => 'vers la salle 209 au deuxième étage'],
            ['Id_emplacement' => 2, 'libelle' => 'Local', 'details' => 'près du bureau ESCPA au 3ème etage'],
            /*
            ['Id_emplacement' => 3, 'libelle' => 'Emplacement 3', 'details' => 'Troisième emplacement'],
            ['Id_emplacement' => 4, 'libelle' => 'Emplacement 4', 'details' => 'Quatrième emplacement'],
            ['Id_emplacement' => 5, 'libelle' => 'Emplacement 5', 'details' => 'Cinquième emplacement']
            */
        ]);
// Batiment A PCs (3ème étage à côté du bureau ESCPA)
        $pcBatimentA = [];
        for ($i = 1; $i <= 32; $i++) {
            $pcBatimentA[] = [
                'Id_PC' => count($pcBatimentA) + 1,
                'libelle' => sprintf('PEGUY-PRET-A-%02d', $i),
                'disponible' => true,
                'date_dispo' => null,
                'Id_emplacement' => 2 // Local près du bureau ESCPA
            ];
        }

        // Batiment B PCs (bureau info)
        $pcBatimentB = [];
        for ($i = 1; $i <= 32; $i++) {
            $pcBatimentB[] = [
                'Id_PC' => count($pcBatimentA) + count($pcBatimentB) + 1,
                'libelle' => sprintf('PEGUY-PRET-B-%02d', $i),
                'disponible' => true,
                'date_dispo' => null,
                'Id_emplacement' => 1 // Bureau informatique
            ];
        }

        DB::table('pc')->insert(array_merge($pcBatimentA, $pcBatimentB));

        /*
        DB::table('pc')->insert([
            ['Id_PC' => 1, 'libelle' => 'PC-001', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 1],
            ['Id_PC' => 2, 'libelle' => 'PC-002', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 1],
            ['Id_PC' => 3, 'libelle' => 'PC-003', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 1],
            ['Id_PC' => 4, 'libelle' => 'PC-004', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 2],
            ['Id_PC' => 5, 'libelle' => 'PC-005', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 2],
            ['Id_PC' => 6, 'libelle' => 'PC-006', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 2],
            ['Id_PC' => 7, 'libelle' => 'PC-007', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 3],
            ['Id_PC' => 8, 'libelle' => 'PC-008', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 3],
            ['Id_PC' => 9, 'libelle' => 'PC-009', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 3],
            ['Id_PC' => 10, 'libelle' => 'PC-010', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 4],
            ['Id_PC' => 11, 'libelle' => 'PC-011', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 4],
            ['Id_PC' => 12, 'libelle' => 'PC-012', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 4],
            ['Id_PC' => 13, 'libelle' => 'PC-013', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 5],
            ['Id_PC' => 14, 'libelle' => 'PC-014', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 5],
            ['Id_PC' => 15, 'libelle' => 'PC-015', 'disponible' => true, 'date_dispo' => null, 'Id_emplacement' => 5]
        ]);
        */

        DB::table('eleve')->insert([
            ['Id_Eleve' => 1, 'nom' => 'Dupont', 'prenom' => 'Jean'],
            ['Id_Eleve' => 2, 'nom' => 'Martin', 'prenom' => 'Marie'],
            ['Id_Eleve' => 3, 'nom' => 'Bernard', 'prenom' => 'Pierre'],
            ['Id_Eleve' => 4, 'nom' => 'Dubois', 'prenom' => 'Sophie'],
            ['Id_Eleve' => 5, 'nom' => 'Petit', 'prenom' => 'Lucas'],
            ['Id_Eleve' => 6, 'nom' => 'Robert', 'prenom' => 'Emma'],
            ['Id_Eleve' => 7, 'nom' => 'Thomas', 'prenom' => 'Alice'],
            ['Id_Eleve' => 8, 'nom' => 'Richard', 'prenom' => 'Paul'],
            ['Id_Eleve' => 9, 'nom' => 'Moreau', 'prenom' => 'Julie'],
            ['Id_Eleve' => 10, 'nom' => 'Simon', 'prenom' => 'Louis'],
            ['Id_Eleve' => 11, 'nom' => 'Laurent', 'prenom' => 'Clara'],
            ['Id_Eleve' => 12, 'nom' => 'Michel', 'prenom' => 'Hugo'],
            ['Id_Eleve' => 13, 'nom' => 'Leroy', 'prenom' => 'Léa'],
            ['Id_Eleve' => 14, 'nom' => 'Roux', 'prenom' => 'Nathan'],
            ['Id_Eleve' => 15, 'nom' => 'David', 'prenom' => 'Camille'],
            ['Id_Eleve' => 16, 'nom' => 'Bertrand', 'prenom' => 'Mathis'],
            ['Id_Eleve' => 17, 'nom' => 'Vincent', 'prenom' => 'Eva'],
            ['Id_Eleve' => 18, 'nom' => 'Fournier', 'prenom' => 'Tom'],
            ['Id_Eleve' => 19, 'nom' => 'Morel', 'prenom' => 'Jade'],
            ['Id_Eleve' => 20, 'nom' => 'Girard', 'prenom' => 'Adam'],
            ['Id_Eleve' => 21, 'nom' => 'Andre', 'prenom' => 'Lena'],
            ['Id_Eleve' => 22, 'nom' => 'Lefebvre', 'prenom' => 'Jules'],
            ['Id_Eleve' => 23, 'nom' => 'Mercier', 'prenom' => 'Zoe'],
            ['Id_Eleve' => 24, 'nom' => 'Blanc', 'prenom' => 'Leo'],
            ['Id_Eleve' => 25, 'nom' => 'Guerin', 'prenom' => 'Manon']
        ]);

        DB::table('professeur')->insert([
            ['id' => 6, 'name' => 'Smith', 'prenom' => 'John', 'email' => 'smith@example.com', 'password' => bcrypt('password')],
            ['id' => 7, 'name' => 'Johnson', 'prenom' => 'Sarah', 'email' => 'johnson@example.com', 'password' => bcrypt('password')],
            ['id' => 8, 'name' => 'Brown', 'prenom' => 'Michael', 'email' => 'brown@example.com', 'password' => bcrypt('password')],
            ['id' => 9, 'name' => 'Davis', 'prenom' => 'Emma', 'email' => 'davis@example.com', 'password' => bcrypt('password')],
            ['id' => 10, 'name' => 'Wilson', 'prenom' => 'David', 'email' => 'wilson@example.com', 'password' => bcrypt('password')]
        ]);

        DB::table('classe')->insert([
            ['Id_Classe' => 1, 'libelle' => 'Terminal A'],
            ['Id_Classe' => 2, 'libelle' => 'Terminal B'],
            ['Id_Classe' => 3, 'libelle' => 'Terminal C'],
            ['Id_Classe' => 4, 'libelle' => 'Terminal D'],
            ['Id_Classe' => 5, 'libelle' => 'Terminal E']
        ]);

        DB::table('salle')->insert([
            ['Id_Salle' => 1, 'Libelle' => 'Salle 101'],
            ['Id_Salle' => 2, 'Libelle' => 'Salle 102'],
            ['Id_Salle' => 3, 'Libelle' => 'Salle 103'],
            ['Id_Salle' => 4, 'Libelle' => 'Salle 104'],
            ['Id_Salle' => 5, 'Libelle' => 'Salle 105']
        ]);

        DB::table('reservation')->insert([
            ['Id_Reservation' => 1, 'r_date' => '2024-01-15', 'heure_debut' => '08:00:00', 'heure_fin' => '10:00', 'Id_Salle' => 1, 'Id_Professeur' => 6, 'statut' => 'En attente', 'motif' => null],
            ['Id_Reservation' => 2, 'r_date' => '2024-01-16', 'heure_debut' => '10:00:00', 'heure_fin' => '12:00', 'Id_Salle' => 2, 'Id_Professeur' => 7, 'statut' => 'En attente', 'motif' => null],
            ['Id_Reservation' => 3, 'r_date' => '2024-01-17', 'heure_debut' => '14:00:00', 'heure_fin' => '16:00', 'Id_Salle' => 3, 'Id_Professeur' => 8, 'statut' => 'En attente', 'motif' => null],
            ['Id_Reservation' => 4, 'r_date' => '2024-01-18', 'heure_debut' => '09:00:00', 'heure_fin' => '11:00', 'Id_Salle' => 4, 'Id_Professeur' => 9, 'statut' => 'En attente', 'motif' => null],
            ['Id_Reservation' => 5, 'r_date' => '2024-01-19', 'heure_debut' => '13:00:00', 'heure_fin' => '15:00', 'Id_Salle' => 5, 'Id_Professeur' => 10, 'statut' => 'En attente', 'motif' => null]
        ]);

        DB::table('ligne_reservation')->insert([
            ['Id_ligne_reservation' => 1, 'Id_Reservation' => 1, 'Id_PC' => 1, 'Id_Eleve' => 1],
            ['Id_ligne_reservation' => 2, 'Id_Reservation' => 2, 'Id_PC' => 2, 'Id_Eleve' => 2],
            ['Id_ligne_reservation' => 3, 'Id_Reservation' => 3, 'Id_PC' => 3, 'Id_Eleve' => 3],
            ['Id_ligne_reservation' => 4, 'Id_Reservation' => 4, 'Id_PC' => 4, 'Id_Eleve' => 4],
            ['Id_ligne_reservation' => 5, 'Id_Reservation' => 5, 'Id_PC' => 5, 'Id_Eleve' => 5]
        ]);

        DB::table('etre_membre')->insert([
            ['Id_Eleve' => 1, 'Id_Classe' => 1],
            ['Id_Eleve' => 2, 'Id_Classe' => 1],
            ['Id_Eleve' => 3, 'Id_Classe' => 1],
            ['Id_Eleve' => 4, 'Id_Classe' => 1],
            ['Id_Eleve' => 5, 'Id_Classe' => 1],
            ['Id_Eleve' => 6, 'Id_Classe' => 2],
            ['Id_Eleve' => 7, 'Id_Classe' => 2],
            ['Id_Eleve' => 8, 'Id_Classe' => 2],
            ['Id_Eleve' => 9, 'Id_Classe' => 2],
            ['Id_Eleve' => 10, 'Id_Classe' => 2],
            ['Id_Eleve' => 11, 'Id_Classe' => 3],
            ['Id_Eleve' => 12, 'Id_Classe' => 3],
            ['Id_Eleve' => 13, 'Id_Classe' => 3],
            ['Id_Eleve' => 14, 'Id_Classe' => 3],
            ['Id_Eleve' => 15, 'Id_Classe' => 3],
            ['Id_Eleve' => 16, 'Id_Classe' => 4],
            ['Id_Eleve' => 17, 'Id_Classe' => 4],
            ['Id_Eleve' => 18, 'Id_Classe' => 4],
            ['Id_Eleve' => 19, 'Id_Classe' => 4],
            ['Id_Eleve' => 20, 'Id_Classe' => 4],
            ['Id_Eleve' => 21, 'Id_Classe' => 5],
            ['Id_Eleve' => 22, 'Id_Classe' => 5],
            ['Id_Eleve' => 23, 'Id_Classe' => 5],
            ['Id_Eleve' => 24, 'Id_Classe' => 5],
            ['Id_Eleve' => 25, 'Id_Classe' => 5]
        ]);

        DB::table('enseigner')->insert([
            ['Id_Professeur' => 6, 'Id_Classe' => 1],
            ['Id_Professeur' => 7, 'Id_Classe' => 2],
            ['Id_Professeur' => 8, 'Id_Classe' => 3],
            ['Id_Professeur' => 9, 'Id_Classe' => 4],
            ['Id_Professeur' => 10, 'Id_Classe' => 5]
        ]);
    }
}