import { getCookie, convertDecimalHoursToHumanReadable } from './utils.js'
let modal;
document.addEventListener('DOMContentLoaded', () => {
    loadCours();
    createPopupParticipants();
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
        const response = await fetch('/api/coachs.php?id='+userId, {
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
        <p>Salle: ${c.salle.nom}</p>
        <p>Duree:  ${realHours} </p>
        <p>${c.nbParticipants}/${c.nbMax}</p>
        <button class="participants-btn" data-cours-id="${c.id_cours}">Voir les participants</button>
    `;

        list.appendChild(li);
    });
    document.querySelectorAll('.participants-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const coursId = btn.dataset.coursId;

            modal.style.display = 'flex';

            const listEl = document.getElementById('participants-list');
            listEl.innerHTML = '<li>Chargement...</li>';

            try {
                const res = await fetch(`/api/adherents.php?cours_id=${coursId}`, {
                    credentials: 'include'
                });
                const data = await res.json();

                listEl.innerHTML = ''; // vide le loader
                if (data.length === 0) {
                    listEl.innerHTML = '<li>Aucun participant pour ce cours</li>';
                } else {
                    data.forEach(p => {
                        const li = document.createElement('li');
                        li.textContent = `${p.nom} ${p.prenom} (${p.statut})`;
                        listEl.appendChild(li);
                    });
                }
            } catch (err) {
                listEl.innerHTML = '<li>Erreur lors du chargement des participants</li>';
                console.error(err);
            }
        });
    });

    console.log('[Cours] Rendu terminé');
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


function createPopupParticipants()
{
    // 1. Création de la modal dans le DOM
    modal = document.createElement('div');
    modal.id = 'participants-modal';
    modal.style.display = 'none'; // caché au départ
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.style.zIndex = '1000';
    modal.innerHTML = `
    <div style="background:#fff; padding:20px; border-radius:8px; max-width:500px; width:90%;">
        <h3>Participants</h3>
        <ul id="participants-list"></ul>
        <button id="close-participants">Fermer</button>
    </div>
`;
    document.body.appendChild(modal);

    document.getElementById('close-participants').addEventListener('click', () => {
        modal.style.display = 'none';
        document.getElementById('participants-list').innerHTML = '';
    });
}
