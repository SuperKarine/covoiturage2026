
document.querySelectorAll('.etoiles').forEach(function (conteneur) {
    const etoiles = conteneur.querySelectorAll('.etoile');

    etoiles.forEach(function (etoile) {
        etoile.addEventListener('mouseenter', function () {
            const valeur = parseInt(etoile.dataset.valeur);
            surlignerEtoiles(etoiles, valeur);
        });

        etoile.addEventListener('click', function () {
            const valeur = parseInt(etoile.dataset.valeur);
            const idTrajet = parseInt(conteneur.dataset.idTrajet);
            const idChauffeur = parseInt(conteneur.dataset.idChauffeur);

            envoyerNote(valeur, idTrajet, idChauffeur, conteneur);
        });
    });

    conteneur.addEventListener('mouseleave', function () {
        surlignerEtoiles(etoiles, 0);
    });
});

function surlignerEtoiles(etoiles, valeur) {
    etoiles.forEach(function (etoile) {
        const v = parseInt(etoile.dataset.valeur);
        etoile.textContent = v <= valeur ? '\u2605' : '\u2606';
    });
}

function envoyerNote(valeur, idTrajet, idChauffeur, conteneur) {
    fetch('/api/notes', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            note: valeur,
            id_utilisateurs: idChauffeur,
            id_trajet: idTrajet,
            id_auteur: idPassagerConnecte
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Erreur : ' + data.error);
            } else {
                conteneur.innerHTML = `Note envoyée : ${valeur} / 5`;
            }
        })
        .catch(error => console.error('Erreur :', error));
}