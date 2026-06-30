
<h1 class="mb-4">Rechercher un trajet</h1>

<form id="form-recherche" class="row g-3 mb-5">
    <div class="col-md-3">
        <label for="ville_depart" class="form-label">Ville de départ</label>
        <select id="ville_depart" name="ville_depart" class="form-select">
            <option value="">Toutes</option>
            <option value="Lille">Lille</option>
            <option value="Amiens">Amiens</option>
            <option value="Calais">Calais</option>
            <option value="Dunkerque">Dunkerque</option>
            <option value="Arras">Arras</option>
            <option value="Boulogne-sur-Mer">Boulogne-sur-Mer</option>
            <option value="Saint-Quentin">Saint-Quentin</option>
            <option value="Beauvais">Beauvais</option>
            <option value="Compiègne">Compiègne</option>
            <option value="Valenciennes">Valenciennes</option>
            <option value="Douai">Douai</option>
            <option value="Lens">Lens</option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="ville_arrivee" class="form-label">Ville d'arrivée</label>
        <select id="ville_arrivee" name="ville_arrivee" class="form-select">
            <option value="">Toutes</option>
            <option value="Lille">Lille</option>
            <option value="Amiens">Amiens</option>
            <option value="Calais">Calais</option>
            <option value="Dunkerque">Dunkerque</option>
            <option value="Arras">Arras</option>
            <option value="Boulogne-sur-Mer">Boulogne-sur-Mer</option>
            <option value="Saint-Quentin">Saint-Quentin</option>
            <option value="Beauvais">Beauvais</option>
            <option value="Compiègne">Compiègne</option>
            <option value="Valenciennes">Valenciennes</option>
            <option value="Douai">Douai</option>
            <option value="Lens">Lens</option>
        </select>
    </div>

    <div class="col-md-2">
        <label for="date_depart" class="form-label">Date de départ</label>
        <input type="date" id="date_depart" name="date_depart" class="form-control">
    </div>

    <div class="col-md-2">
        <label for="places_min" class="form-label">Places minimum</label>
        <input type="number" id="places_min" name="places_min" class="form-control" min="1" value="1">
    </div>

    <div class="col-md-2">
        <label for="prix_max" class="form-label">Prix maximum (€)</label>
        <input type="number" id="prix_max" name="prix_max" class="form-control" min="0" step="0.5">
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" id="fumeur" name="fumeur" class="form-check-input">
            <label for="fumeur" class="form-check-label">Fumeur autorisé</label>
        </div>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" id="animaux" name="animaux" class="form-check-input">
            <label for="animaux" class="form-check-label">Animaux autorisés</label>
        </div>
    </div>

    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Rechercher</button>
    </div>
</form>

<div id="resultats" class="row g-4">
    <!-- Les cards de trajets  -->
</div>

<script>
    const estConnecte = <?= $estConnecte ? 'true' : 'false' ?>;
    const idUtilisateurConnecte = <?= $idUtilisateur ? (int) $idUtilisateur : 'null' ?>;
</script>

<script src="/assets/js/trajets.js"></script>