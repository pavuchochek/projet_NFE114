import { getCookie, convertDecimalHoursToHumanReadable } from './utils.js'
let modal;
document.addEventListener('DOMContentLoaded', () => {
    loadCours();
    loadCoachs();
    loadAdherents();
    loadPrixAPayerParCoach();
    loadSalles();
});

async function loadCours() {
    const res = await fetch('/api/cours.php', { credentials: 'include' });
    const cours = await res.json();

    const container = document.getElementById('cours-container');
    container.innerHTML = '';

    cours.forEach(c => {
        const card = document.createElement('div');
        card.className = 'stat-card';

        card.innerHTML = `
            <h3>${c.nom}</h3>
            <p>${c.date_heure}</p>
            <p>Salle : ${c.salle.nom}</p>
            <p>${c.nb_inscrits}/${c.capacite}</p>
        `;

        container.appendChild(card);
    });
}


async function loadCoachs() {
    const res = await fetch('/api/coachs.php', { credentials: 'include' });
    const coachs = await res.json();

    const container = document.getElementById('coachs-container');
    container.innerHTML = '';

    coachs.forEach(c => {
        const card = document.createElement('div');
        card.className = 'stat-card';

        card.innerHTML = `
            <h3>${c.nom} ${c.prenom}</h3>
            <p>${c.email}</p>
            <p>${c.prix_heure} €/h</p>
        `;

        container.appendChild(card);
    });
}
async function loadAdherents() {
    const res = await fetch('/api/adherents.php', { credentials: 'include' });
    const adherents = await res.json();

    const container = document.getElementById('adherents-container');
    container.innerHTML = '';

    adherents.forEach(a => {
        const card = document.createElement('div');
        card.className = 'stat-card';

        card.innerHTML = `
            <h3>${a.nom} ${a.prenom}</h3>
            <p>${a.email}</p>
            <p>Adhésion : ${a.date_adherence}</p>
        `;

        container.appendChild(card);
    });
}
async function loadSalles() {
    const res = await fetch('/api/salles.php', { credentials: 'include' });
    const salles = await res.json();

    const container = document.getElementById('salles-container');
    container.innerHTML = '';

    salles.forEach(s => {
        const card = document.createElement('div');
        card.className = 'stat-card';

        card.innerHTML = `
            <h3>${s.nom}</h3>
            <p>Capacité : ${s.capacite}</p>
        `;

        container.appendChild(card);
    });
}

async function loadPrixAPayerParCoach() {
    const res = await fetch('/api/paiement_coachs.php', { credentials: 'include' });
    const data = await res.json();

    const container = document.getElementById('prix-container');
    container.innerHTML = '';

    data.forEach(c => {
        const div = document.createElement('div');
        div.className = 'stat-card';

        div.innerHTML = `
            <h3>${c.coach}</h3>
            <p>Séances : ${c.nb_seances}</p>
            <p>Heures : ${c.total_heures}</p>
            <p><strong>${c.total_a_payer} €</strong></p>
        `;

        container.appendChild(div);
    });
}



