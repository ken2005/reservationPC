<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvController extends Controller
{
    public function importProfesseurs(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\User::create([
                'name' => $row[0],
                'prenom' => $row[1],
                'email' => $row[2],
                'password' => bcrypt($row[3])
            ]);
        }

        return redirect()->back()->with('success', 'Professeurs importés avec succès');
    }

    public function importEleves(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\Eleve::create([
                'nom' => $row[0],
                'prenom' => $row[1]
            ]);
        }

        return redirect()->back()->with('success', 'Élèves importés avec succès');
    }

    public function importClasses(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\Classe::create([
                'libelle' => $row[0]
            ]);
        }

        return redirect()->back()->with('success', 'Classes importées avec succès');
    }

    public function importPCs(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\PC::create([
                'libelle' => $row[0],
                'serial_number' => $row[1],
                'marque' => $row[2],
                'modele' => $row[3],
                'type_chargeur' => $row[4],
                'Id_emplacement' => $row[5]
            ]);
        }

        return redirect()->back()->with('success', 'PCs importés avec succès');
    }

    public function importSalles(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\Salle::create([
                'libelle' => $row[0]
            ]);
        }

        return redirect()->back()->with('success', 'Salles importées avec succès');
    }

    public function importEtreMembre(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\EtreMembre::create([
                'Id_Eleve' => $row[0],
                'Id_Classe' => $row[1]
            ]);
        }

        return redirect()->back()->with('success', 'Membres importés avec succès');
    }

    public function importEnseigner(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        foreach ($csvData as $row) {
            \App\Models\Enseigner::create([
                'Id_Professeur' => $row[0],
                'Id_Classe' => $row[1]
            ]);
        }

        return redirect()->back()->with('success', 'Enseignements importés avec succès');
    }

    public function exportProfesseurs()
    {
        $professeurs = \App\Models\User::all();
        
        $filename = 'professeurs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($professeurs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['name', 'prenom', 'email']);
            
            foreach ($professeurs as $professeur) {
                fputcsv($file, [$professeur->name, $professeur->prenom, $professeur->email]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportEleves()
    {
        $eleves = \App\Models\Eleve::all();
        
        $filename = 'eleves_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($eleves) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['nom', 'prenom']);
            
            foreach ($eleves as $eleve) {
                fputcsv($file, [$eleve->nom, $eleve->prenom]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportClasses()
    {
        $classes = \App\Models\Classe::all();
        
        $filename = 'classes_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($classes) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['libelle']);
            
            foreach ($classes as $classe) {
                fputcsv($file, [$classe->libelle]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportPCs()
    {
        $pcs = \App\Models\PC::with('emplacement')->get();
        
        $filename = 'pcs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pcs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['libelle', 'serial_number', 'marque', 'modele', 'type_chargeur', 'Id_emplacement']);
            
            foreach ($pcs as $pc) {
                fputcsv($file, [
                    $pc->libelle,
                    $pc->serial_number,
                    $pc->marque,
                    $pc->modele,
                    $pc->type_chargeur,
                    $pc->Id_emplacement
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportSalles()
    {
        $salles = \App\Models\Salle::all();
        
        $filename = 'salles_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($salles) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['libelle']);
            
            foreach ($salles as $salle) {
                fputcsv($file, [$salle->libelle]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportEtreMembre()
    {
        $membres = \App\Models\EtreMembre::all();
        
        $filename = 'etremembre_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($membres) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Id_Eleve', 'Id_Classe']);
            
            foreach ($membres as $membre) {
                fputcsv($file, [$membre->Id_Eleve, $membre->Id_Classe]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function exportEnseigner()
    {
        $enseignements = \App\Models\Enseigner::all();
        
        $filename = 'enseigner_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($enseignements) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Id_Professeur', 'Id_Classe']);
            
            foreach ($enseignements as $enseignement) {
                fputcsv($file, [$enseignement->Id_Professeur, $enseignement->Id_Classe]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
