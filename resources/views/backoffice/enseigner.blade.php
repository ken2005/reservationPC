@extends('layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<div class="container">
    <h2 class="card p-2">Gestion des Enseignements</h2>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            Ajouter un enseignement
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.enseigner.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="professeur">Professeur</label>
                    <select class="form-control" id="professeur" name="Id_Professeur" required>
                        <option value="">Sélectionnez un professeur</option>
                        @foreach($professeurs as $professeur)
                            <option value="{{ $professeur->id }}">{{ $professeur->name }} {{ $professeur->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="classe">Classe</label>
                    <select class="form-control" id="classe" name="Id_Classe" required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->Id_Classe }}">{{ $classe->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Import CSV -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Importer des enseignements via CSV</span>
            <a href="{{ asset('csv/enseigner_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
        </div>
        <div class="card-body">
            <form action="{{ route('import.enseigner') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Fichier CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
            </form>
        </div>
    </div>

    <!-- Liste des enseignements -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des enseignements</span>
            <a href="{{ route('export.enseigner') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Professeur</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($enseignements as $enseignement)
                    <tr>
                        <td>{{ $enseignement->professeur->name }} {{ $enseignement->professeur->prenom }}</td>
                        <td>{{ $enseignement->classe->libelle }}</td>
                        <td>
                            <a href="{{ route('backoffice.enseigner.edit', ['Id_Professeur' => $enseignement->Id_Professeur, 'Id_Classe' => $enseignement->Id_Classe]) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('backoffice.enseigner.destroy', ['Id_Professeur' => $enseignement->Id_Professeur, 'Id_Classe' => $enseignement->Id_Classe]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignement ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
