@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier un élève</h2>

    <div class="card">
        <div class="card-header">
            Modifier l'élève : {{ $eleve->nom }} {{ $eleve->prenom }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.eleve.update', $eleve->Id_Eleve) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ $eleve->nom }}" required maxlength="50">
                </div>
                
                <div class="form-group mb-3">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $eleve->prenom }}" required maxlength="50">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('eleves.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 