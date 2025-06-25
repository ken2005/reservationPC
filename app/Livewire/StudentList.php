<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StudentList extends Component
{
    public int $classeSelectionee ;
    public $eleves = [];
    public $classes;
    public $selectedEleves = [];
    public $search = '';

    public function mount()
    {




        $this->classes = DB::table('classe')->get();
    }

    
    public function updatedClasse($value)
    {
        $this->selectedEleves = [];
        if ($value) {
            $this->eleves = DB::table('eleve')
            ->select('eleve.*')
            ->join('etre_membre', 'eleve.Id_Eleve', '=', 'etre_membre.Id_Eleve')
            ->where('etre_membre.Id_Classe', $value)
            ->whereLike('eleve.nom', '%' . $this->search . '%')
            ->get();
        } else {
            $this->eleves = [];
        }
        $this->classeSelectionee = $value;
    }
    
    public function aaa(){
        /*
        dd(DB::table('eleve')
        ->select('eleve.*')
        ->join('etre_membre', 'eleve.Id_Eleve', '=', 'etre_membre.Id_Eleve')
        ->where('etre_membre.Id_Classe', $this->classeSelectionee)
        ->get());
        dd($this->classeSelectionee);
        dd($this->selectedEleves);
        */
        $this->eleves = DB::table('eleve')
        ->select('eleve.*')
        ->join('etre_membre', 'eleve.Id_Eleve', '=', 'etre_membre.Id_Eleve')
        ->where('etre_membre.Id_Classe', $this->classeSelectionee)
        ->whereLike('eleve.nom', '%' . $this->search . '%')
        ->get();
    }
    public function render()
    {
        return view('livewire.student-list',[
            'eleves' => $this->eleves,
            'classes' => $this->classes
        ]);
    }
}
