
document.getElementById('form-ajouter-trajet').addEventListener('submit', function (e) {
    e.preventDefault();

    const data = {
        id_utilisateurs: parseInt(document.getElementById('id_utilisateurs').value),
        id_voiture: parseInt(document.getElementById('id_voiture').value),
        id_ville_depart: parseInt(document.getElementById('id_ville_depart').value),
        id_ville_arrivee: parseInt(document.getElementById('id_ville_arrivee').value),
        date_depart: document.getElementById('date_depart').value.replace('T', ' ') + ':00',
        nbr_places_dispo: parseInt(document.getElementById('nbr_places_dispo').value),
        prix: parseFloat(document.getElementById('prix').value),
        fumeur: document.getElementById('fumeur').checked,
        animaux: document.getElementById('animaux').checked,
    };

    fetch('/api/trajets', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {
            const messageDiv = document.getElementById('message');
            if (result.error) {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.error}</div>`;
            } else {
                messageDiv.innerHTML = `<div class="alert alert-success">Trajet créé avec succès !</div>`;
                setTimeout(() => {
                    window.location.href = '/chauffeur/dashboard';
                }, 1500);
            }
        })
        .catch(error => console.error('Erreur :', error));
});