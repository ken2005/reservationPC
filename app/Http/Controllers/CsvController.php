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

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $password = isset($row[3]) ? $row[3] : substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);
            $batch[] = [
                'name' => strtoupper($row[0]),
                'prenom' => ucfirst(strtolower($row[1])),
                'email' => $row[2],
                'password' => bcrypt($password),
                'default_password' => $password,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'email' => $row[2],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\User::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['email'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'email' => $rowMap[0]['email'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    // On coupe le batch en deux et on retente
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };

        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' professeurs importés avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : {$fail['email']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importEleves(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'nom' => $row[0],
                'prenom' => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'nom' => $row[0],
                'prenom' => $row[1],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\Eleve::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['nom'] . ' ' . $row['prenom'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'nom' => $rowMap[0]['nom'],
                        'prenom' => $rowMap[0]['prenom'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' élèves importés avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : {$fail['nom']} {$fail['prenom']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importClasses(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'libelle' => $row[0],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'libelle' => $row[0],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\Classe::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['libelle'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'libelle' => $rowMap[0]['libelle'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' classes importées avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : {$fail['libelle']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importPCs(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'libelle' => $row[0],
                'serial_number' => $row[1],
                'marque' => $row[2],
                'modele' => $row[3],
                'type_chargeur' => $row[4],
                'Id_emplacement' => $row[5],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'libelle' => $row[0],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\PC::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['libelle'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'libelle' => $rowMap[0]['libelle'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' PCs importés avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : {$fail['libelle']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importSalles(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'libelle' => $row[0],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'libelle' => $row[0],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\Salle::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['libelle'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'libelle' => $rowMap[0]['libelle'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' salles importées avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : {$fail['libelle']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importEtreMembre(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'Id_Eleve' => $row[0],
                'Id_Classe' => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'Id_Eleve' => $row[0],
                'Id_Classe' => $row[1],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\EtreMembre::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['Id_Eleve'] . '-' . $row['Id_Classe'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'Id_Eleve' => $rowMap[0]['Id_Eleve'],
                        'Id_Classe' => $rowMap[0]['Id_Classe'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' membres importés avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : Eleve {$fail['Id_Eleve']} / Classe {$fail['Id_Classe']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
    }

    public function importEnseigner(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        array_shift($csvData);

        $successes = [];
        $failures = [];
        $batch = [];
        $rowMap = [];

        foreach ($csvData as $index => $row) {
            $batch[] = [
                'Id_Professeur' => $row[0],
                'Id_Classe' => $row[1],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $rowMap[] = [
                'ligne' => $index + 2,
                'Id_Professeur' => $row[0],
                'Id_Classe' => $row[1],
            ];
        }

        $tryInsert = function($batch, $rowMap) use (&$successes, &$failures, &$tryInsert) {
            if (empty($batch)) return;
            try {
                \App\Models\Enseigner::insert($batch);
                foreach ($rowMap as $row) {
                    $successes[] = $row['Id_Professeur'] . '-' . $row['Id_Classe'];
                }
            } catch (\Exception $e) {
                if (count($batch) == 1) {
                    $errorMsg = $e->getMessage();
                    if (strpos($errorMsg, 'Duplicate entry') !== false) {
                        $errorMsg = "Doublon : cet enregistrement existe déjà (vérifiez les champs uniques).";
                    }
                    $failures[] = [
                        'ligne' => $rowMap[0]['ligne'],
                        'Id_Professeur' => $rowMap[0]['Id_Professeur'],
                        'Id_Classe' => $rowMap[0]['Id_Classe'],
                        'erreur' => $errorMsg
                    ];
                } else {
                    $mid = intdiv(count($batch), 2);
                    $tryInsert(array_slice($batch, 0, $mid), array_slice($rowMap, 0, $mid));
                    $tryInsert(array_slice($batch, $mid), array_slice($rowMap, $mid));
                }
            }
        };
        $tryInsert($batch, $rowMap);

        $message = 'Import terminé. ';
        if (count($successes) > 0) {
            $message .= count($successes) . ' enseignements importés avec succès : ' . implode(', ', $successes) . '. ';
        }
        if (count($failures) > 0) {
            $message .= count($failures) . ' échecs : ';
            foreach ($failures as $fail) {
                $message .= "[Ligne {$fail['ligne']} : Prof {$fail['Id_Professeur']} / Classe {$fail['Id_Classe']} - {$fail['erreur']}] ";
            }
        }

        $type = 'success';
        if (count($successes) === 0 && count($failures) > 0) {
            $type = 'error';
        } elseif (count($successes) > 0 && count($failures) > 0) {
            $type = 'warning';
        }
        return redirect()->back()->with($type, $message);
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
