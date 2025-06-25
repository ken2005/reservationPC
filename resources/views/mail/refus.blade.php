<h1>Votre réservation a été refusée.</h1>
<br><br>
<div style="font-weight: bold; color: #2c3e50;">Détails de la réservation :</div>
<div style="margin: 10px 0; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
    <p>Date : {{ $reservation->r_date }}</p>
    <p>Heure de début : {{ $reservation->heure_debut }}</p>
    <p>Heure de fin : {{ $reservation->heure_fin }}</p>
    <p>Salle : {{ $reservation->salle_libelle }}</p>
</div>
<br>
<div style="font-weight: bold; color: #e74c3c;">Motif du refus :</div>
<br>
<textarea readonly style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; background-color: #f9f9f9; font-family: Arial, sans-serif; min-height: 100px; resize: none;">{{ $reason }}</textarea>

<br>
<br>
<div style="color: #2c3e50; margin-top: 20px;">
    Bien à vous,<br>
    <span style="font-weight: bold; color: #3498db;">Le service de gestion des PCs</span>
</div>