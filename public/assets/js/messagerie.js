
document.getElementById('form-nouveau-message').addEventListener('submit', function (e) {
    e.preventDefault();

    const idDestinataire = parseInt(document.getElementById('id_destinataire').value);
    const contenu = document.getElementById('contenu').value;

    fetch('/api/messages', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_expediteur: idChauffeurConnecte,
            id_destinataire: idDestinataire,
            contenu: contenu
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                alert('Message envoyé');
                location.reload();
            }
        })
        .catch(error => console.error('Erreur :', error));
});

function marquerLu(idMessage) {
    fetch(`/api/messages/${idMessage}/lu`, { method: 'PUT' })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                location.reload();
            }
        })
        .catch(error => console.error('Erreur :', error));
}

function supprimerMessage(idMessage) {
    if (!confirm('Supprimer ce message ?')) return;

    fetch(`/api/messages/${idMessage}`, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                location.reload();
            }
        })
        .catch(error => console.error('Erreur :', error));
}
