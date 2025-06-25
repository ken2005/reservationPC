  @extends('layouts.app')

  @section('content')
  <div class="container">
      <h2 class="card p-2">Gestion des Ordinateurs</h2>

      <!-- Formulaire d'ajout -->
      <div class="card mb-4">
          <div class="card-header">
              Ajouter un ordinateur
          </div>
          <div class="card-body">
              <form action="{{ route('backoffice.pc.store') }}" method="POST">
                  @csrf
                  <div class="form-group">
                      <label for="libelle">Libellé</label>
                      <input type="text" class="form-control" id="libelle" name="libelle" required maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="serial_number">N° Série</label>
                      <input type="text" class="form-control" id="serial_number" name="serial_number" maxlength="50">
                  </div>
                  <div class="form-group">
                      <label for="marque">Marque</label>
                      <input type="text" class="form-control" id="marque" name="marque">
                  </div>
                  <div class="form-group">
                      <label for="modele">Modèle</label>
                      <input type="text" class="form-control" id="modele" name="modele">
                  </div>
                  <div class="form-group">
                      <label for="type_chargeur">Type Chargeur</label>
                      <input type="text" class="form-control" id="type_chargeur" name="type_chargeur">
                  </div>
                  <div class="form-group">
                      <label for="Id_emplacement">Emplacement</label>
                      <select class="form-control" id="Id_emplacement" name="Id_emplacement" required>
                          @foreach($emplacements as $emplacement)
                              <option value="{{ $emplacement->Id_emplacement }}">{{ $emplacement->libelle }}</option>
                          @endforeach
                      </select>
                  </div>
                  <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
              </form>
          </div>
      </div>

      <!-- Import CSV -->
      <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
              <span>Importer des ordinateurs via CSV</span>
              <a href="{{ asset('csv/pcs_modele.csv') }}" class="btn btn-info btn-sm" download>Télécharger le modèle</a>
          </div>
          <div class="card-body">
              <form action="{{ route('import.pcs') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                      <label for="csv_file">Fichier CSV</label>
                      <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv" required>
                  </div>
                  <button type="submit" class="btn btn-success mt-3 ms-2">Importer</button>
              </form>
          </div>
      </div>

      <!-- Liste des ordinateurs -->
      <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
              <span>Liste des ordinateurs</span>
              <a href="{{ route('export.pcs') }}" class="btn btn-warning btn-sm">Exporter en CSV</a>
          </div>
          <div class="card-body">
              <table class="table">
                  <thead>
                      <tr>
                          <th>Libellé</th>
                          <th>N° Série</th>
                          <th>Marque</th>
                          <th>Modèle</th>
                          <th>Type Chargeur</th>
                          <th>Emplacement</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach($pcs as $pc)
                      <tr>
                          <td>{{ $pc->libelle }}</td>
                          <td>{{ $pc->serial_number }}</td>
                          <td>{{ $pc->marque }}</td>
                          <td>{{ $pc->modele }}</td>
                          <td>{{ $pc->type_chargeur }}</td>
                          <td>{{ $pc->emplacement->libelle }}</td>
                          <td>
                              <a href="{{ route('backoffice.pc.edit', $pc->Id_PC) }}" class="btn btn-warning btn-sm">Modifier</a>
                              <form action="{{ route('backoffice.pc.destroy', $pc->Id_PC) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet ordinateur ?')">Supprimer</button>
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