  @extends('layouts.app')

  @section('content')
  <div class="container">
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif

      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif

      <div class="card">
          <div class="card-header bg-light">
              <h2 class="mb-0">Liste des PC</h2>
          </div>
          <div class="card-body">
              @foreach($pcs->groupBy('emplacement.libelle') as $emplacement => $pcGroup)
              <h4 class="mt-3">{{ $emplacement ?? 'Non défini' }}</h4>
              <div class="table-responsive mb-4">
                  <table class="table">
                      <thead class="bg-light">
                          <tr>
                              <th>Libellé</th>
                              <th>Disponibilité</th>
                              <th>Date de remise à disposition</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($pcGroup as $pc)
                          <tr>
                              <td>{{ $pc->libelle }}</td>
                              <td>{{ $pc->disponible ? 'Disponible' : 'Indisponible' }}</td>
                              <td>{{ $pc->date_dispo ?? 'N/A' }}</td>
                              <td>
                                  @if($pc->disponible)
                                      <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#indispoModal" data-pc-id="{{ $pc->Id_PC }}">
                                          Rendre indisponible
                                      </button>
                                  @else
                                      <form action="{{ route('pc.toggle-availability', $pc->Id_PC) }}" method="POST" style="display: inline;">
                                          @csrf
                                          @method('PUT')
                                          <button type="submit" class="btn btn-sm btn-success">Remettre à disposition</button>
                                      </form>
                                  @endif
                              </td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                    <hr>
              </div>
              @endforeach
          </div>
      </div>
  </div>

  <!-- Modal pour rendre indisponible -->
  <div class="modal fade" id="indispoModal" tabindex="-1" aria-labelledby="indispoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="indispoModalLabel">Date de remise à disposition</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('pc.toggle-availability', '') }}" method="POST" id="indispoForm">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                          <label for="date_dispo">Date de remise à disposition éstimée :</label>
                          <input type="date" class="form-control" id="date_dispo" name="date_dispo" >
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                          <button type="submit" class="btn btn-warning">Confirmer</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>

  <style>
      .card {
          box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
          background-color: #ffffff;
      }

      .card-header {
          border-bottom: 1px solid rgba(0, 0, 0, 0.125);
      }

      .table {
          margin-bottom: 0;
      }

      .table th, .table td {
          padding: 12px;
          vertical-align: middle;
      }

      .btn-sm {
          padding: 5px 10px;
          font-size: 12px;
          margin: 0 2px;
      }
  </style>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
      var indispoModal = document.getElementById('indispoModal');
      indispoModal.addEventListener('show.bs.modal', function (event) {
          var button = event.relatedTarget;
          var pcId = button.getAttribute('data-pc-id');
          var form = document.getElementById('indispoForm');
          form.action = form.action + '/' + pcId;
      });
  });
  </script>
  @endsection