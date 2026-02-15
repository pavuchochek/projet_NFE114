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
        <h2>Mes cours à venir</h2>
        <ul id="cours_list"></ul>
    </div>
</div>

<script src="/assets/js/dashboard_coach.js" defer></script>
<script src="/assets/js/general.js" defer></script>
</body>
</html>
