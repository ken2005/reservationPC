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

      <div class="card mb-4">
          <div class="card-header bg-light">
              <h2 class="mb-0">Nouvelle Réservation</h2>
          </div>
          <div class="card-body">
              <form id="reservationForm" method="POST" action="{{ route('reservation.store') }}">
                  @csrf
                  @livewire('student-list')

                  @livewire('pc-dispos')

                  <div class="form-group">
                      <label for="salle">Salle:</label>
                      <select id="salle" name="Id_Salle" required>
                          @foreach($salles as $salle)
                              <option value="{{ $salle->Id_Salle }}">{{ $salle->libelle }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Sélectionnez un PC:</label>
                      <div class="pc-grid" id="pcGrid"></div>
                  </div>

                  <button type="submit" id="submitBt" class="btn btn-primary">Réserver</button>
              </form>
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

      .form-group {
          margin-bottom: 20px;
      }

      label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
      }

      input, select {
          width: 100%;
          padding: 8px;
          border: 1px solid #ddd;
          border-radius: 4px;
      }

      .pc-grid {
          display: grid;
          grid-template-columns: repeat(5, 1fr);
          gap: 10px;
          margin: 20px 0;
      }

      .pc-item {
          padding: 10px;
          text-align: center;
          border: 1px solid #ddd;
          border-radius: 4px;
          cursor: pointer;
      }

      .pc-item.available {
          background-color: #e8f5e9;
      }

      .pc-item.reserved {
          background-color: #ffebee;
          cursor: not-allowed;
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

      .alert {
          padding: 15px;
          margin-bottom: 20px;
          border: 1px solid transparent;
          border-radius: 4px;
      }

      .alert-success {
          color: #155724;
          background-color: #d4edda;
          border-color: #c3e6cb;
      }

      .alert-danger {
          color: #721c24;
          background-color: #f8d7da;
          border-color: #f5c6cb;
      }
  </style>

  
  @endsection