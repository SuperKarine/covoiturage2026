
document.getElementById('form-recherche').addEventListener('submit', function (e) {
    e.preventDefault();
    rechercherTrajets();
});

// Recherche initiale au chargement de la page (tous les trajets)
document.addEventListener('DOMContentLoaded', rechercherTrajets);

function rechercherTrajets() {
    const params = new URLSearchParams();

    const villeDepart = document.getElementById('ville_depart').value;
    const villeArrivee = document.getElementById('ville_arrivee').value;
    const dateDepart = document.getElementById('date_depart').value;
    const placesMin = document.getElementById('places_min').value;
    const prixMax = document.getElementById('prix_max').value;
    const fumeur = document.getElementById('fumeur').checked;
    const animaux = document.getElementById('animaux').checked;

    if (villeDepart) params.append('ville_depart', villeDepart);
    if (villeArrivee) params.append('ville_arrivee', villeArrivee);
    if (dateDepart) params.append('date_depart', dateDepart);
    if (placesMin) params.append('places_min', placesMin);
    if (prixMax) params.append('prix_max', prixMax);
    if (fumeur) params.append('fumeur', '1');
    if (animaux) params.append('animaux', '1');

    fetch('/api/trajets?' + params.toString())
    .then(response => response.json())
    .then(trajets => afficherResultats(trajets))
    .catch(error => console.error('Erreur lors de la recherche :', error));
}

function afficherResultats(trajets) {
    const conteneur = document.getElementById('resultats');
    conteneur.innerHTML = '';

    if (trajets.length === 0) {
        conteneur.innerHTML = '<p class="text-muted">Aucun trajet trouvé.</p>';
        return;
    }

    trajets.forEach(trajet => {
        const card = document.createElement('div');
        card.className = 'col-md-4';

        card.innerHTML = `
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">${trajet.ville_depart} → ${trajet.ville_arrivee}</h5>
                    <p class="card-text">
                        <strong>Date :</strong> ${trajet.date_depart}<br>
                        <strong>Prix :</strong> ${trajet.prix} €<br>
                        <strong>Places disponibles :</strong> ${trajet.nbr_places_dispo}<br>
                        <strong>Chauffeur :</strong> ${trajet.chauffeur_prenom} ${trajet.chauffeur_nom}<br>
                        <strong>Véhicule :</strong> ${trajet.voiture_modele} (${trajet.voiture_energie})<br>
                        <strong>Fumeur :</strong> ${trajet.fumeur ? 'Autorisé' : 'Non autorisé'}<br>
                        <strong>Animaux :</strong> ${trajet.animaux ? 'Autorisés' : 'Non autorisés'}
                    </p>
                </div>
            </div>
        `;

        conteneur.appendChild(card);
    });
}