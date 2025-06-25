  @extends('layouts.app')

  @section('content')
  <div class="container">
      <h2 class="card p-2">Gestion des Professeurs</h2>

      <!-- Formulaire d'ajout -->
      <div class="card mb-4">
          <div class="card-header">
              Ajouter un professeur
          </div>
          <div class="card-body">
              <form action="{{ route('backoffice.professeur.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                      <label for="name">Nom</label>
                      <input type="text" class="form-control" id="name" name="name" required maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="prenom">Prénom</label>
                      <input type="text" class="form-control" id="prenom" name="prenom" required maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <div class="form-group">
                      <label for="password">Mot de passe</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
              </form>
          </div>
      </div>

      <!-- Import CSV -->
      <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
              <span>Importer des professeurs via CSV</span>
              <a href="{{ asset('csv/professeurs_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
          </div>
          <div class="card-body">
              <form action="{{ route('import.professeurs') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label for="csv_file">Fichier CSV</label>
                      <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                  </div>
                  <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
              </form>
          </div>
      </div>

      <!-- Liste des professeurs -->
      <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
              <span>Liste des professeurs</span>
              <a href="{{ route('export.professeurs') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
          </div>
          <div class="card-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Nom</th>
                          <th>Prénom</th>
                          <th>Email</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($professeurs as $professeur)
                      <tr>
                          <td>{{ $professeur->id }}</td>
                          <td>{{ $professeur->name }}</td>
                          <td>{{ $professeur->prenom }}</td>
                          <td>{{ $professeur->email }}</td>
                          <td>
                              <a href="{{ route('backoffice.professeur.edit', $professeur->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                              <form action="{{ route('backoffice.professeur.destroy', $professeur->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">Supprimer</button>
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