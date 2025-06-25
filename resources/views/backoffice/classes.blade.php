@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Gestion des Classes</h2>

    <!-- Formulaire d'ajout -->
    <div class="card mb-4">
        <div class="card-header">
            Ajouter une classe
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.classe.store') }}" method="POST">
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
            <span>Importer des classes via CSV</span>
            <a href="{{ asset('csv/classes_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
        </div>
        <div class="card-body">
            <form action="{{ route('import.classes') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Fichier CSV</label>
                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
            </form>
        </div>
    </div>

    <!-- Liste des classes -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Liste des classes</span>
            <a href="{{ route('export.classes') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
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
                    @foreach($classes as $classe)
                    <tr>
                        <td>{{ $classe->Id_Classe }}</td>
                        <td>{{ $classe->libelle }}</td>
                        <td>
                            <a href="{{ route('backoffice.classe.edit', $classe->Id_Classe) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('backoffice.classe.destroy', $classe->Id_Classe) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette classe ?')">Supprimer</button>
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