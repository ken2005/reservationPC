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
    <h2 class="card p-2">Gestion des Membres de Classes</h2>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            Ajouter un membre à une classe
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.etre-membre.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="eleve">Élève</label>
                    <select class="form-control" id="eleve" name="Id_Eleve" required>
                        <option value="">Sélectionnez un élève</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->Id_Eleve }}">{{ $eleve->nom }} {{ $eleve->prenom }}</option>
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
            <span>Importer des membres via CSV</span>
            <a href="{{ asset('csv/etremembre_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
        </div>
        <div class="card-body">
            <form action="{{ route('import.etre-membre') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Fichier CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
            </form>
        </div>
    </div>

    <!-- Liste des membres -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des membres de classes</span>
            <a href="{{ route('export.etremembre') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memberships as $membership)
                    <tr>
                        <td>{{ $membership->eleve->nom }} {{ $membership->eleve->prenom }}</td>
                        <td>{{ $membership->classe->libelle }}</td>
                        <td>
                            <a href="{{ route('backoffice.etre-membre.edit', ['Id_Eleve' => $membership->Id_Eleve, 'Id_Classe' => $membership->Id_Classe]) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('backoffice.etre-membre.destroy', ['Id_Eleve' => $membership->Id_Eleve, 'Id_Classe' => $membership->Id_Classe]) }}" method="POST" class="d-inline">
                                @csrf                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">Supprimer</button>
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