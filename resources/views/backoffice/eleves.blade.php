@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Gestion des Élèves</h2>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            Ajouter un élève
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.eleve.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required maxlength="50">
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" required maxlength="50">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Import CSV -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Importer des élèves via CSV</span>
            <a href="{{ asset('csv/eleves_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
        </div>
        <div class="card-body">
            <form action="{{ route('import.eleves') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Fichier CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
            </form>
        </div>
    </div>

    <!-- Liste des élèves -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des élèves</span>
            <a href="{{ route('export.eleves') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                    <tr>
                        <td>{{ $eleve->Id_Eleve }}</td>
                        <td>{{ $eleve->nom }}</td>
                        <td>{{ $eleve->prenom }}</td>
                        <td>
                            <a href="{{ route('backoffice.eleve.edit', $eleve->Id_Eleve) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('backoffice.eleve.destroy', $eleve->Id_Eleve) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?')">Supprimer</button>
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
