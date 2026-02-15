import { getCookie, convertDecimalHoursToHumanReadable } from './utils.js'
document.addEventListener('DOMContentLoaded', () => {
    loadCours();
    loadReservations();
    loadHistory();
    loadProfil();
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

        renderCours(data);
    } catch (error) {
        console.error('[Cours] Erreur', error);
    }
}

async function loadProfil() {
    console.log('[Profil] Fetch démarré');
    const userId = getCookie('user_id');
    try {
        const response = await fetch('/api/adherents.php?id='+userId, {
            credentials: 'include'
        });
        console.log('[Profil] Réponse reçue', response.status);
        const data = await response.json();
        renderProfil(data);
    } catch (error) {
        console.error('[Profil] Erreur', error);
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

async function loadHistory() {
    console.log('[Historique] Fetch démarré');
    const userId = getCookie('user_id');
    try{
        const response = await fetch('/api/history.php?id='+userId, {
            credentials: 'include'
        });
        console.log('[Historique] Réponse reçue', response.status);
        const data = await response.json();
        renderHistory(data);
    }catch(error){
        console.error('[Historique] Erreur', error);
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
        const realHours = convertDecimalHoursToHumanReadable(c.duree);

        li.innerHTML = `
        <h3>${c.nom}</h3>
        <p>${c.description ?? ''}</p>
        <p><strong>${c.date_heure ?? ''}</strong></p>
        <p>Coach: ${c.coach.nom} ${c.coach.prenom}</p>
        <p>Salle: ${c.salle.nom}</p>
        <p>Duree:  ${realHours} </p>
        <div class="card-actions">
            <button data-id="${c.id_cours}">Réserver</button>
        </div>
    `;

        li.querySelector('button').addEventListener('click', () => {
            console.log('[Cours] Réservation demandée pour', c.id_cours);
            reserverCours(c.id_cours);
        });

        list.appendChild(li);
    });

    console.log('[Cours] Rendu terminé');
}
function renderHistory(history) {
    console.log('[Historique] Rendu en cours');
    const list = document.getElementById('history_list');
    list.innerHTML = '';

    if (!history.length) {
        list.innerHTML = '<p>Aucun historique de réservation</p>';
        return;
    }

    history.forEach(h => {
        const li = document.createElement('li');
        li.className = 'cours';
        const realHours = convertDecimalHoursToHumanReadable(h.duree);

        li.innerHTML = `
        <h3>${h.nom}</h3>
        <p><strong>Date :</strong> ${h.date_heure}</p>
        <p><strong>Coach :</strong> ${h.coach.nom} ${h.coach.prenom}</p>
        <p><strong>Salle :</strong> ${h.salle.nom}</p>
        <p><strong>Durée :</strong> ${realHours}</p>
        <p><strong>Statut :</strong> ${h.statut}</p>
    `;

        list.appendChild(li);
    });

    console.log('[Historique] Rendu terminé');
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

        let actionsHTML = '';
        if (r.statut === 'en attente') {
            actionsHTML = `<button data-id="${r.cours.id_cours}" class="button-confirm-reservation">Confirmer</button>`;
            actionsHTML = actionsHTML+ '<button data-id="${r.cours.id_cours}" class="button-cancel-reservation">Annuler</button>';
        }

        li.innerHTML = `
        <h3>${r.cours.nom}</h3>
        <p><strong>Date du cours :</strong> ${r.cours.date_heure}</p>
        <p><strong>Date de réservation :</strong> ${r.date_reservation}</p>
        <p><strong>Statut :</strong> ${r.statut}</p>
        <p><strong>Coach :</strong> ${r.cours.coach.nom} ${r.cours.coach.prenom}</p>
        <p><strong>Salle :</strong> ${r.cours.salle.nom}</p>
        <div class="reservation-actions">
            ${actionsHTML}
        </div>
    `;

        const btn = li.querySelector('button');
        if (btn) {
            btn.addEventListener('click', () => {
                console.log('[Réservation] Confirmer cours', r.cours.id_cours);
                confirmReservation(r.cours.id_cours);
            });
        }

        const cancelBtn = li.querySelector('.button-cancel-reservation');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                console.log('[Réservation] Annuler cours', r.cours.id_cours);
                cancelReservation(r.cours.id_cours);
            }
            );
        }

        list.appendChild(li);
    });



    console.log('[Réservations] Rendu terminé');
}

function renderProfil(profil) {
    console.log('[Profil] Rendu en cours');

    const container = document.getElementById('informations_personnelles');

    // Nettoyer le contenu existant sauf le <h2>
    const heading = container.querySelector('h2');
    container.innerHTML = '';
    container.appendChild(heading);

    // Créer les <p> avec la structure HTML correspondante
    const nom = document.createElement('p');
    nom.innerHTML = `<strong>Nom :</strong> ${profil.nom}`;

    const prenom = document.createElement('p');
    prenom.innerHTML = `<strong>Prénom :</strong> ${profil.prenom}`;

    const email = document.createElement('p');
    email.innerHTML = `<strong>Email :</strong> ${profil.email}`;

    // Ajouter les éléments au container
    container.appendChild(nom);
    container.appendChild(prenom);
    container.appendChild(email);
}

function confirmReservation(coursId) {
    console.log('[Réservation] Confirmation demandée pour le cours', coursId);
    var userId = getCookie('user_id');
    fetch('/api/reservations.php', {
        method: 'PATCH',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        }
        ,
        body: JSON.stringify({
            cours_id: coursId
        })
    }).then(response => {
        if (response.ok) {
            console.log('[Réservation] Confirmation réussie');
            loadReservations() // Recharger les réservations pour mettre à jour l'affichage
        }
    }).catch(error => {
        console.error('[Réservation] Erreur lors de la confirmation', error);
    });
}

function cancelReservation(coursId) {
    console.log('[Réservation] Annulation demandée pour le cours', coursId);
    var userId = getCookie('user_id');
    fetch('/api/reservations.php?id='+coursId, {
        method: 'DELETE',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        }
    } ).then(response => {
        if (response.ok) {
            console.log('[Réservation] Annulation réussie');
            loadCours()
            loadReservations() // Recharger les réservations pour mettre à jour l'affichage
        }
    }).catch(error => {
        console.error('[Réservation] Erreur lors de l\'annulation', error);
    });
}

function reserverCours(coursId) {
    console.log('[Cours] Réservation demandée pour le cours', coursId);
    fetch('/api/reservations.php', {
        method: 'POST',
        credentials: 'include',
        headers: {
            'Content-Type': 'application/json'
        }
        ,
        body: JSON.stringify({
            cours_id: coursId
        })
    }).then(response => {
        if (response.ok) {
            console.log('[Cours] Réservation réussie');
            loadCours()
            loadReservations() // Recharger les réservations pour mettre à jour l'affichage
        }
        });
}