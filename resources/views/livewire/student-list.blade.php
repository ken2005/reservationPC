<div>
    <div class="form-group">
        <label for="class">Classe:</label>
        <select id="class" name="classe" wire:model.live="classeSelectionee" wire:change="aaa" required>
            <option value="0" selected>Sélectionnez la classe</option>
            @foreach ($classes as $classe)
            <option value="{{ $classe->Id_Classe }}" wire:click="updatedClasse({{ $classe->Id_Classe }}})">{{ $classe->libelle }}</option>
            @endforeach
        </select>
        classe : {{ $classeSelectionee }}
        @error('classe')
            <div class="text-danger">{{ $message }}</div>
            @enderror
    </div>
    <div class="form-group">
        <label for="eleves">Eleves</label>
        <div style="width: 300px;">
            <div style="border: 1px solid #ccc; border-radius: 4px;">
                <div style="padding: 8px; border-bottom: 1px solid #ccc;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Rechercher des élèves...">
                </div>
                
                <div class="checkbox-list" style="height: 200px; overflow-y: auto; padding: 8px;">
                    @foreach($eleves as $eleve)
                    <div class="checkbox-item">
                        <label style="display: flex; align-items: center;">
                            <input type="checkbox" wire:model="selectedEleves" value="{{$eleve->Id_Eleve}}" name="eleve[]">
                            <span style="margin-left: 0px;">{{$eleve->nom}} {{$eleve->prenom}}</span>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @error('eleve')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchText = this.value.toLowerCase();
            let checkboxItems = document.querySelectorAll('.checkbox-item');
            
            checkboxItems.forEach(item => {
                let label = item.querySelector('label').textContent.toLowerCase();
                if (label.includes(searchText)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        document.getElementById('class').addEventListener('change', function() {
            let classeId = this.value;
            console.log('selection de '+classeId);
            let checkboxItems = document.querySelectorAll('.checkbox-item');
            checkboxItems.forEach(item => {
                if (true != item.checked) {
                    console.log('item '+item.checked);
                    item.click();
                }
                //item.checked = false;

        });


        });
    </script>
</div>

