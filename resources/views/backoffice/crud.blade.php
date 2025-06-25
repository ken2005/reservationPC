@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Gestion des Professeurs -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Gestion des Professeurs</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('professeur.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nom du professeur</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Ajouter un professeur</button>
            </form>
            
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($professeurs as $professeur)
                    <tr>
                        <td>{{ $professeur->id }}</td>
                        <td>{{ $professeur->name }}</td>
                        <td>
                            <a href="" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('professeur.destroy', $professeur->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des Élèves -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Gestion des Élèves</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('eleve.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Ajouter un élève</button>
            </form>

            <table class="table mt-3">
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
                            <a href="" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('eleve.destroy', $eleve->Id_Eleve) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des Classes -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Gestion des Classes</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('classe.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Libellé</label>
                    <input type="text" name="libelle" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Ajouter une classe</button>
            </form>

            <table class="table mt-3">
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
                            <a href="#" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('classe.destroy', $classe->Id_Classe) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Gestion des Ordinateurs -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Gestion des Ordinateurs</h2>
        </div>
        <div class="card-body">
            <a class="btn btn-secondary mt-2" href="{{ route('pc.create') }}">Creer un PC</a>
            
            @foreach($pcs->groupBy('emplacement.libelle') as $emplacement => $pcGroup)
            <h4 class="mt-3">{{ $emplacement ?? 'Non défini' }}</h4>
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libellé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pcGroup as $pc)
                    <tr>
                        <td>{{ $pc->Id_PC }}</td>
                        <td>{{ $pc->libelle }}</td>
                        <td>
                            <a href="#" class="btn btn-warning">Modifier</a>
                            <form action="{{ route('pc.destroy', $pc->Id_PC) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach
        </div>
    </div>
</div>
@endsection