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
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th>Date</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Salle</th>
                            <th>
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>PC</th>
                                            <th>Élève</th>
                                        </tr>
                                    </thead>
                                </table>
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
                                <table class="table table-sm">
                                    @foreach($groupedReservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->pc_libelle }}</td>
                                            <td>{{ $reservation->nom }} {{ $reservation->prenom }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </td>
                            <td>
                                @if (Auth::user()->id == 1)
                                                                    <form action="{{ route('reservation.validate') }}" method="POST" style="display: inline;" {{ $groupedReservations[0]->statut == 'Validée' ? 'hidden' : '' }}>
                                                                        @csrf
                                                                        <input type="hidden" name="reservationId" value="{{ $groupedReservations[0]->Id_Reservation }}">
                                                                        <button type="submit" class="btn btn-sm btn-success">Valider</button>
                                                                    </form>
                                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#refuseModal" data-reservation-id="{{ $groupedReservations[0]->Id_Reservation }}">Refuser</button>                                @else
                                    
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var refuseModal = document.getElementById('refuseModal');
    refuseModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var reservationId = button.getAttribute('data-reservation-id');
        document.getElementById('reservationId').value = reservationId;
    });
});
</script>
@endsection