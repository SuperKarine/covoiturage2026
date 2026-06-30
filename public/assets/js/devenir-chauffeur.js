
document.getElementById('btn-devenir-chauffeur').addEventListener('click', function () {
    fetch('/api/demandes-chauffeur', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id_utilisateurs: idPassagerConnecte })
    })
    .then(res => res.json())
    .then(data => {
        if (data.id_demande) {
            document.getElementById('msg-demande').innerHTML =
                '<div class="alert alert-success">Demande envoyée ! Vous recevrez un email avec les documents à fournir.</div>';
            document.getElementById('btn-devenir-chauffeur').disabled = true;
        } else {
            document.getElementById('msg-demande').innerHTML =
                '<div class="alert alert-danger">Erreur : ' + (data.error ?? 'inconnue') + '</div>';
        }
    });
});
