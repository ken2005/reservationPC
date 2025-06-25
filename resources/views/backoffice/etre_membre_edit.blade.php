@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier un membre de classe</h2>

    <div class="card">
        <div class="card-header">
            Modifier le membre : ID Élève {{ $etreMembre->Id_Eleve }} - ID Classe {{ $etreMembre->Id_Classe }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.etre-membre.update', ['Id_Eleve' => $etreMembre->Id_Eleve, 'Id_Classe' => $etreMembre->Id_Classe]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="Id_Eleve">Élève</label>
                    <select class="form-control" id="Id_Eleve" name="Id_Eleve" required>
                        <option value="">Sélectionnez un élève</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->Id_Eleve }}" {{ $etreMembre->Id_Eleve == $eleve->Id_Eleve ? 'selected' : '' }}>
                                {{ $eleve->nom }} {{ $eleve->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="Id_Classe">Classe</label>
                    <select class="form-control" id="Id_Classe" name="Id_Classe" required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->Id_Classe }}" {{ $etreMembre->Id_Classe == $classe->Id_Classe ? 'selected' : '' }}>
                                {{ $classe->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('etre-membre.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 