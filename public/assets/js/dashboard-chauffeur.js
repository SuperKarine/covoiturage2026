
function confirmerReservation(idReservation) {
    fetch(`/api/reservations/${idReservation}/confirmer`, { method: 'POST' })
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

function refuserReservation(idReservation) {
    fetch(`/api/reservations/${idReservation}/refuser`, { method: 'POST' })
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