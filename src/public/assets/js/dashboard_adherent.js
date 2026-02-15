console.log('[Dashboard] Script chargé');

document.addEventListener('DOMContentLoaded', () => {
    console.log('[Dashboard] DOM prêt');

    loadCours();
    loadReservations();
});

/**
 * Fetch des cours disponibles
 */
async function loadCours() {
    console.log('[Cours] Fetch démarré');

    try {
        const response = await fetch('/api/cours.php', {
            credentials: 'include'
        });

        console.log('[Cours] Réponse reçue', response.status);

        const data = await response.json();
        console.log('[Cours] Données', data);
        const parsedCours = data.map(c => JSON.parse(c));

        renderCours(parsedCours);
    } catch (error) {
        console.error('[Cours] Erreur', error);
    }
}

/**
 * Fetch des réservations utilisateur
 */
async function loadReservations() {
    console.log('[Réservations] Fetch démarré');

    try {
        const response = await fetch('/api/reservations.php', {
            credentials: 'include'
        });

        console.log('[Réservations] Réponse reçue', response.status);

        const data = await response.json();
        console.log('[Réservations] Données', data);

        renderReservations(data);
    } catch (error) {
        console.error('[Réservations] Erreur', error);
    }
}

/**
 * Rendu des cours
 */
function renderCours(cours) {
    console.log('[Cours] Rendu en cours');

    const list = document.getElementById('cours_list');
    list.innerHTML = '';

    if (!cours.length) {
        list.innerHTML = '<p>Aucun cours disponible</p>';
        return;
    }

    cours.forEach(c => {
        const li = document.createElement('li');
        li.className = 'cours';
        console.log('[Cours] Rendu du cours', c.nom);

        li.innerHTML = `
        <h3>${c.nom}</h3>
        <p>${c.description ?? ''}</p>
        <p><strong>${c.date_heure ?? ''}</strong></p>
        <p>Coach: ${c.coach.nom} ${c.coach.prenom}</p>
        <p>Salle: ${c.salle.nom}</p>
        <div class="card-actions">
            <button data-id="${c.id_cours}">Réserver</button>
        </div>
    `;

        li.querySelector('button').addEventListener('click', () => {
            console.log('[Cours] Réservation demandée pour', c.id_cours);
        });

        list.appendChild(li);
    });

    console.log('[Cours] Rendu terminé');
}

/**
 * Rendu des réservations
 */
function renderReservations(reservations) {
    console.log('[Réservations] Rendu en cours');

    const list = document.getElementById('reservations_list');
    list.innerHTML = '';

    if (!reservations.length) {
        list.innerHTML = '<p>Aucune réservation</p>';
        return;
    }

    reservations.forEach(r => {
        const li = document.createElement('li');
        li.className = 'reservation';

        li.innerHTML = `
            <h3>${r.cours_nom}</h3>
            <p>${r.date}</p>
        `;

        list.appendChild(li);
    });

    console.log('[Réservations] Rendu terminé');
}
