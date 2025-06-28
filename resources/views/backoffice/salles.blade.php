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
    <h2 class="card p-2">Gestion des Salles</h2>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            Ajouter une salle
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.salle.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control" id="libelle" name="libelle" required maxlength="50">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
            </form>
        </div>
    </div>

    <!-- Import CSV -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Importer des salles via CSV</span>
            <a href="{{ asset('csv/salles_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
        </div>
        <div class="card-body">
            <form action="{{ route('import.salles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Fichier CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
            </form>
        </div>
    </div>

    <!-- Liste des salles -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des salles</span>
            <a href="{{ route('export.salles') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salles as $salle)
                    <tr>
                        <td>{{ $salle->Id_Salle }}</td>
                        <td>{{ $salle->libelle }}</td>
                        <td>
                            <a href="{{ route('backoffice.salle.edit', $salle->Id_Salle) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('backoffice.salle.destroy', $salle->Id_Salle) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?')">Supprimer</button>
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
