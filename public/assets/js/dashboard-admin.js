
function accepterDemande(idDemande) {
    fetch(`/api/demandes-chauffeur/${idDemande}/accepter`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                alert(data.message);
                location.reload();
            }
        })
        .catch(error => console.error('Erreur :', error));
}

function refuserDemande(idDemande) {
    fetch(`/api/demandes-chauffeur/${idDemande}/refuser`, { method: 'POST' })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                alert(data.message);
                location.reload();
            }
        })
        .catch(error => console.error('Erreur :', error));
}