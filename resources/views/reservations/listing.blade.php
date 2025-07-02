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
            <h2 class="mb-0">Liste des réservations</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="reservationsTable">
                    <thead class="bg-light">
                        <tr>
                            <th>
                                Date
                                <input type="date" class="form-control filter-input" data-column="0">
                            </th>
                            <th>
                                Début
                                <input type="text" class="form-control filter-input" data-column="1" placeholder="Filtrer...">
                            </th>
                            <th>
                                Fin
                                <input type="text" class="form-control filter-input" data-column="2" placeholder="Filtrer...">
                            </th>
                            <th>
                                Salle
                                <input type="text" class="form-control filter-input" data-column="3" placeholder="Filtrer...">
                            </th>
                            <th>
                                PC / Élèves
                                <div class="row">
                                    <div class="col-6">
                                        <input type="text" class="form-control filter-input" id="pcFilter" placeholder="Filtrer PC...">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control filter-input" id="eleveFilter" placeholder="Filtrer élève...">
                                    </div>
                                </div>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations->groupBy('Id_Reservation') as $groupedReservations)
                        <tr>
                            <td>{{ $groupedReservations[0]->r_date }}</td>
                            <td>{{ $groupedReservations[0]->heure_debut }}</td>
                            <td>{{ $groupedReservations[0]->heure_fin }}</td>
                            <td>{{ $groupedReservations[0]->Libelle }}</td>
                            <td>
                                <div class="pc-eleves-container">
                                    @foreach($groupedReservations as $reservation)
                                        <div class="pc-eleve-row">
                                            <strong>{{ $reservation->pc_libelle }}</strong> - {{ $reservation->nom }} {{ $reservation->prenom }}
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Données cachées pour le filtrage -->
                                <span class="d-none eleve-data">
                                    @foreach($groupedReservations as $reservation)
                                        {{ $reservation->nom }} {{ $reservation->prenom }} 
                                    @endforeach
                                </span>
                                <span class="d-none pc-data">
                                    @foreach($groupedReservations as $reservation)
                                        {{ $reservation->pc_libelle }} 
                                    @endforeach
                                </span>
                            </td>
                            <td>
                                @if (Auth::user()->id == 1)
                                    <form action="{{ route('reservation.validate') }}" method="POST" style="display: inline;" {{ $groupedReservations[0]->statut == 'Validée' ? 'hidden' : '' }}>
                                        @csrf
                                        <input type="hidden" name="reservationId" value="{{ $groupedReservations[0]->Id_Reservation }}">
                                        <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#refuseModal" data-reservation-id="{{ $groupedReservations[0]->Id_Reservation }}">Refuser</button>
                                @else
                                    <form action="{{ route('reservation.destroy', ['id' => $groupedReservations[0]->Id_Reservation]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal de refus -->
<div class="modal fade" id="refuseModal" tabindex="-1" aria-labelledby="refuseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refuseModalLabel">Motif du refus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reservation.refuse') }}" method="POST" id="refuseForm">
                    @csrf
                    <div class="form-group">
                        <label for="refuseReason">Veuillez indiquer le motif du refus :</label>
                        <textarea class="form-control" id="refuseReason" name="reason" rows="3" required></textarea>
                        <input type="hidden" id="reservationId" name="reservationId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Confirmer le refus</button>
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

    .filter-input {
        width: 100%;
        margin-top: 5px;
        font-size: 12px;
    }

    .pc-eleve-row {
        margin-bottom: 5px;
        padding: 2px 5px;
        background-color: #f8f9fa;
        border-radius: 3px;
    }

    .pc-eleves-container {
        max-height: 150px;
        overflow-y: auto;
    }

    /* Style pour les filtres PC/Élève côte à côte */
    .row {
        margin: 0;
    }

    .col-6 {
        padding: 0 2px;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var refuseModal = document.getElementById('refuseModal');
    refuseModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var reservationId = button.getAttribute('data-reservation-id');
        document.getElementById('reservationId').value = reservationId;
    });

    // Initialiser DataTables
    let table = jQuery('#reservationsTable').DataTable({
        "order": [],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
        }
    });

    // Variables pour stocker les valeurs des filtres
    let pcFilterValue = '';
    let eleveFilterValue = '';

    // Fonction de filtrage combiné
    function applyCustomFilters() {
        jQuery.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            if (settings.nTable.id !== 'reservationsTable') {
                return true;
            }
            
            let row = jQuery(table.row(dataIndex).node());
            let pcData = row.find('.pc-data').text().toLowerCase();
            let eleveData = row.find('.eleve-data').text().toLowerCase();
            
            // Vérifier le filtre PC
            let pcMatch = !pcFilterValue || pcData.indexOf(pcFilterValue.toLowerCase()) !== -1;
            
            // Vérifier le filtre Élève
            let eleveMatch = !eleveFilterValue || eleveData.indexOf(eleveFilterValue.toLowerCase()) !== -1;
            
            return pcMatch && eleveMatch;
        });
        
        table.draw();
        
        // Nettoyer le filtre après utilisation
        jQuery.fn.dataTable.ext.search.pop();
    }

    // Appliquer les filtres pour les colonnes simples
    jQuery('.filter-input[data-column]').on('keyup change', function() {
        let column = jQuery(this).data('column');
        let value = jQuery(this).val();
        
        table.column(column).search(value).draw();
    });

    // Filtre PC
    jQuery('#pcFilter').on('keyup', function() {
        pcFilterValue = jQuery(this).val();
        applyCustomFilters();
    });

    // Filtre Élève
    jQuery('#eleveFilter').on('keyup', function() {
        eleveFilterValue = jQuery(this).val();
        applyCustomFilters();
    });
});
</script>

@endsection