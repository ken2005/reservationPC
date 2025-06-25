@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier un ordinateur</h2>

    <div class="card">
        <div class="card-header">
            Modifier l'ordinateur : {{ $pc->libelle }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.pc.update', $pc->Id_PC) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control" id="libelle" name="libelle" value="{{ $pc->libelle }}" required maxlength="50">
                </div>
                
                <div class="form-group mb-3">
                    <label for="serial_number">N° Série</label>
                    <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $pc->serial_number }}" maxlength="50">
                </div>
                
                <div class="form-group mb-3">
                    <label for="marque">Marque</label>
                    <input type="text" class="form-control" id="marque" name="marque" value="{{ $pc->marque }}">
                </div>
                
                <div class="form-group mb-3">
                    <label for="modele">Modèle</label>
                    <input type="text" class="form-control" id="modele" name="modele" value="{{ $pc->modele }}">
                </div>
                
                <div class="form-group mb-3">
                    <label for="type_chargeur">Type Chargeur</label>
                    <input type="text" class="form-control" id="type_chargeur" name="type_chargeur" value="{{ $pc->type_chargeur }}">
                </div>
                
                <div class="form-group mb-3">
                    <label for="Id_emplacement">Emplacement</label>
                    <select class="form-control" id="Id_emplacement" name="Id_emplacement" required>
                        @foreach($emplacements as $emplacement)
                            <option value="{{ $emplacement->Id_emplacement }}" {{ $pc->Id_emplacement == $emplacement->Id_emplacement ? 'selected' : '' }}>
                                {{ $emplacement->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('ordinateurs.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 