@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier un professeur</h2>

    <div class="card">
        <div class="card-header">
            Modifier le professeur : {{ $professeur->name }} {{ $professeur->prenom }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.professeur.update', $professeur->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="name">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $professeur->name }}" required maxlength="50">
                </div>
                
                <div class="form-group mb-3">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $professeur->prenom }}" required maxlength="50">
                </div>
                
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $professeur->email }}" required>
                </div>
                
                <div class="form-group mb-3">
                    <label for="password">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="8">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('professeurs.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 