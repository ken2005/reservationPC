@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="card p-2">Modifier une salle</h2>

    <div class="card">
        <div class="card-header">
            Modifier la salle : {{ $salle->libelle }}
        </div>
        <div class="card-body">
            <form action="{{ route('backoffice.salle.update', $salle->Id_Salle) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="libelle">Libellé</label>
                    <input type="text" class="form-control" id="libelle" name="libelle" value="{{ $salle->libelle }}" required maxlength="50">
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('salles.index') }}" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 