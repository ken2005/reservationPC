<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" wire:model.live="r_date" wire:change="updatePCDispos" name="r_date" required>
    </div>

    <div class="form-group">
        <label for="heure_debut">Heure de début:</label>
        <select id="heure_debut" wire:model.live="heure_debut" wire:change="updatePCDispos" name="heure_debut" required>
            <option value="">Sélectionnez une heure</option>
            <option value="08:00">8h</option>
            <option value="09:00">9h</option>
            <option value="10:00">10h</option>
            <option value="11:00">11h</option>
            <option value="14:00">14h</option>
            <option value="15:00">15h</option>
            <option value="16:00">16h</option>
        </select>
    </div>

    <div class="form-group">
        <label for="heure_fin">Heure de fin:</label>
        <select id="heure_fin" wire:model.live="heure_fin" name="heure_fin" wire:change="updatePCDispos" required>
            <option value="">Sélectionnez une heure</option>
            <option value="09:00">9h</option>
            <option value="10:00">10h</option>
            <option value="11:00">11h</option>
            <option value="12:00">12h</option>
            <option value="15:00">15h</option>
            <option value="16:00">16h</option>
            <option value="17:00">17h</option>
        </select>
    </div>
    PC Dispos : {{ $pcDispos }}

</div>
