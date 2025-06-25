
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ajouter un PC') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pc.store') }}">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>
                            <div class="col-md-6">
                                <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required autocomplete="nom" autofocus>
                                @error('nom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="emplacement_id" class="col-md-4 col-form-label text-md-right">{{ __('Emplacement') }}</label>
                            <div class="col-md-6">
                                <select id="emplacement_id" class="form-control @error('emplacement_id') is-invalid @enderror" name="emplacement_id" required>
                                    <option value="">Sélectionnez un emplacement</option>
                                    @foreach($emplacements as $emplacement)
                                        <option value="{{ $emplacement->Id_emplacement }}">{{ $emplacement->libelle }}</option>
                                    @endforeach
                                </select>
                                @error('emplacement_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ajouter') }}
                                </button>
                                <a href="{{ route('pc.index') }}" class="btn btn-secondary">
                                    {{ __('Annuler') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
