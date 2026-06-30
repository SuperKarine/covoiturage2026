
function annulerReservation(idReservation) {
    fetch(`/api/reservations/${idReservation}/annuler`, { method: 'POST' })
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