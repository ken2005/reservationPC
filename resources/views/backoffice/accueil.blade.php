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

  @section('content')
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">{{ __('Tableau de bord') }}</div>

                  <div class="card-body">
                      <div class="row">
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('professeurs.index') }}" class="btn btn-primary w-100 py-4">
                                  <i class="fas fa-chalkboard-teacher mb-2 d-block" style="font-size: 2rem;"></i>
                                  Professeurs
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('ordinateurs.index') }}" class="btn btn-success w-100 py-4">
                                  <i class="fas fa-desktop mb-2 d-block" style="font-size: 2rem;"></i>
                                  Ordinateurs
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('eleves.index') }}" class="btn btn-info w-100 py-4">
                                  <i class="fas fa-user-graduate mb-2 d-block" style="font-size: 2rem;"></i>
                                  Élèves
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('classes.index') }}" class="btn btn-warning w-100 py-4">
                                  <i class="fas fa-school mb-2 d-block" style="font-size: 2rem;"></i>
                                  Classes
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('salles.index') }}" class="btn btn-danger w-100 py-4">
                                  <i class="fas fa-door-open mb-2 d-block" style="font-size: 2rem;"></i>
                                  Salles
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('enseigner.index') }}" class="btn btn-secondary w-100 py-4">
                                  <i class="fas fa-chalkboard mb-2 d-block" style="font-size: 2rem;"></i>
                                  Enseignements
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('etre-membre.index') }}" class="btn btn-dark w-100 py-4">
                                  <i class="fas fa-users mb-2 d-block" style="font-size: 2rem;"></i>
                                  Membres des classes
                              </a>
                          </div>
                          <div class="col-md-6 mb-4">
                              <a href="{{ route('pc.index') }}" class="btn btn-info w-100 py-4">
                                  <i class="fas fa-laptop-code mb-2 d-block" style="font-size: 2rem;"></i>
                                  État des PC
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  @endsection