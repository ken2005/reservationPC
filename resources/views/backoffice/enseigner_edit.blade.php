@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier un enseignement</h2>

    <div class="card">
        <div class="card-header">
            Modifier l'enseignement : ID Professeur {{ $enseigner->Id_Professeur }} - ID Classe {{ $enseigner->Id_Classe }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.enseigner.update', ['Id_Professeur' => $enseigner->Id_Professeur, 'Id_Classe' => $enseigner->Id_Classe]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="Id_Professeur">Professeur</label>
                    <select class="form-control" id="Id_Professeur" name="Id_Professeur" required>
                        <option value="">Sélectionnez un professeur</option>
                        @foreach($professeurs as $professeur)
                            <option value="{{ $professeur->id }}" {{ $enseigner->Id_Professeur == $professeur->id ? 'selected' : '' }}>
                                {{ $professeur->name }} {{ $professeur->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group mb-3">
                    <label for="Id_Classe">Classe</label>
                    <select class="form-control" id="Id_Classe" name="Id_Classe" required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->Id_Classe }}" {{ $enseigner->Id_Classe == $classe->Id_Classe ? 'selected' : '' }}>
                                {{ $classe->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('enseigner.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 