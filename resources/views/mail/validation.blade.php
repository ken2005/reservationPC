  <h1>Votre réservation a été validée.</h1>
  <br><br>
  <div style="font-weight: bold; color: #2c3e50;">Détails de la réservation :</div>
  <div style="margin: 10px 0; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
      <p>Date : {{ $reservation->r_date }}</p>
      <p>Heure de début : {{ $reservation->heure_debut }}</p>
      <p>Heure de fin : {{ $reservation->heure_fin }}</p>
      <p>Salle : {{ $reservation->salle_libelle }}</p>
  </div>

  <h3>Merci de respecter les attributions et de remettre les PCs à leur place après utilisation</h3>
  <div style="margin: 20px 0;">
      <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
          <thead>
              <tr style="background-color: #f5f5f5;">
                  <th style="padding: 12px; border: 1px solid #ddd;">Lieu de récupération</th>
                  <th style="padding: 12px; border: 1px solid #ddd;">Élève</th>
                  <th style="padding: 12px; border: 1px solid #ddd;">PC</th>
              </tr>
          </thead>
          <tbody>
              @php
                  $groupedReservations = $ligneReservations->groupBy('emplacement_libelle');
              @endphp
              @foreach ($groupedReservations as $emplacement => $lignes)
                  @foreach ($lignes as $ligne)
                      <tr>
                          @if ($loop->first)
                              <td style="padding: 12px; border: 1px solid #ddd;" rowspan="{{ $lignes->count() }}">{{ $emplacement }}</td>
                          @endif
                          <td style="padding: 12px; border: 1px solid #ddd;">{{ $ligne->nom }} {{ $ligne->prenom }}</td>
                          <td style="padding: 12px; border: 1px solid #ddd;">{{ $ligne->libelle }}</td>
                      </tr>
                  @endforeach
              @endforeach
          </tbody>
      </table>
  </div>


  <div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
      <h4 style="color: #2c3e50; margin-bottom: 15px;">Informations sur les lieux de récupération :</h4>
      @foreach ($groupedReservations as $emplacement => $lignes)
          <div style="margin-bottom: 15px; padding: 10px; border-left: 3px solid #3498db;">
              <h5 style="color: #2c3e50; margin-bottom: 5px;">{{ $emplacement }}</h5>
              <p>
                  {{ $lignes->first()->emplacement_details }}
              </p>
          </div>
      @endforeach
  </div>


  <div style="margin-top: 20px; padding: 15px; background-color: #d4edda; border-radius: 5px; color: #155724;">
      <p style="font-weight: bold;">✓ Votre réservation a été confirmée avec succès</p>
      <p>Vous pouvez maintenant utiliser les PCs aux horaires et aux lieux indiqués.</p>
  </div>

  <br>
  <div style="color: #2c3e50; margin-top: 20px;">
      Bien à vous,<br>
      <span style="font-weight: bold; color: #3498db;">Le service de gestion des PCs</span>
  </div>
