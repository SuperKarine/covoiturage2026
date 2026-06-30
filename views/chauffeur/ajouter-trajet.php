
<h1 class="mb-4">Ajouter un trajet</h1>

<form id="form-ajouter-trajet" class="row g-3">
    <input type="hidden" id="id_utilisateurs" value="<?= $_SESSION['user_id'] ?>">

    <div class="col-md-6">
        <label for="id_voiture" class="form-label">Véhicule</label>
        <select id="id_voiture" name="id_voiture" class="form-select" required>
            <?php if (empty($voitures)): ?>
                <option value="">Aucune voiture enregistrée</option>
            <?php else: ?>
                <?php foreach ($voitures as $voiture): ?>
                    <option value="<?= $voiture['id_voiture'] ?>">
                        <?= htmlspecialchars($voiture['modele']) ?> (<?= htmlspecialchars($voiture['energie']) ?>, <?= $voiture['nb_places'] ?> places)
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>

    <div class="col-md-3">
        <label for="id_ville_depart" class="form-label">Ville de départ</label>
        <select id="id_ville_depart" name="id_ville_depart" class="form-select" required>
            <option value="1">Lille</option>
            <option value="2">Amiens</option>
            <option value="3">Calais</option>
            <option value="4">Dunkerque</option>
            <option value="5">Arras</option>
            <option value="6">Boulogne-sur-Mer</option>
            <option value="7">Saint-Quentin</option>
            <option value="8">Beauvais</option>
            <option value="9">Compiègne</option>
            <option value="10">Valenciennes</option>
            <option value="11">Douai</option>
            <option value="12">Lens</option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="id_ville_arrivee" class="form-label">Ville d'arrivée</label>
        <select id="id_ville_arrivee" name="id_ville_arrivee" class="form-select" required>
            <option value="1">Lille</option>
            <option value="2">Amiens</option>
            <option value="3">Calais</option>
            <option value="4">Dunkerque</option>
            <option value="5">Arras</option>
            <option value="6">Boulogne-sur-Mer</option>
            <option value="7">Saint-Quentin</option>
            <option value="8">Beauvais</option>
            <option value="9">Compiègne</option>
            <option value="10">Valenciennes</option>
            <option value="11">Douai</option>
            <option value="12">Lens</option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="date_depart" class="form-label">Date et heure de départ</label>
        <input type="datetime-local" id="date_depart" name="date_depart" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label for="nbr_places_dispo" class="form-label">Places disponibles</label>
        <input type="number" id="nbr_places_dispo" name="nbr_places_dispo" class="form-control" min="1" required>
    </div>

    <div class="col-md-3">
        <label for="prix" class="form-label">Prix (€)</label>
        <input type="number" id="prix" name="prix" class="form-control" min="0" step="0.5" required>
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" id="fumeur" name="fumeur" class="form-check-input">
            <label for="fumeur" class="form-check-label">Fumeur autorisé</label>
        </div>
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check">
            <input type="checkbox" id="animaux" name="animaux" class="form-check-input">
            <label for="animaux" class="form-check-label">Animaux autorisés</label>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Créer le trajet</button>
    </div>
</form>

<div id="message" class="mt-3"></div>

<script src="/assets/js/ajouter-trajet.js"></script>