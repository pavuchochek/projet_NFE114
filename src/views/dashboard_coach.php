<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard coach</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
</head>
<body>

<div id="dashboard">
    <h1>Bienvenue, Coach</h1>
    <button id="logout_btn" style="position:absolute; top:10px; right:10px;">Déconnexion</button>
    <div id="cours_coach">
        <h2>Mes cours</h2>
        <ul id="cours_list"></ul>
    </div>
    <div id="informations_personnelles" class="informations_card">
        <h2>Mes informations personnelles</h2>
        <p><strong>Nom :</strong> <span id="info_nom"></span></p>
        <p><strong>Prénom :</strong> <span id="info_prenom"></span></p>
        <p><strong>Email :</strong> <span id="info_email"></span></p>
    </div>
</div>

<script src="/assets/js/dashboard_coach.js"  type="module" defer></script>
<script src="/assets/js/general.js" defer></script>
</body>
</html>
