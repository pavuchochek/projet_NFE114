<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard admin</title>
    <link rel="stylesheet" href="/assets/css/dashboard.css">

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
</head>
<body>

<div id="dashboard">
    <h1>Bienvenue, Admin</h1>
    <button id="logout_btn" style="position:absolute; top:10px; right:10px;">Déconnexion</button>
    <div id="stats">
            <h2>Statistiques</h2>
            <p>Total des adhérents : <span id="total_adherents"></span></p>
            <p>Total des coachs : <span id="total_coachs"></span></p>
            <p>Total des cours : <span id="total_cours"></span></p>
    </div>
</div>

<script src="/assets/js/dashboard_admin.js" type="module" defer></script>
<script src="/assets/js/general.js" defer></script>
</body>
</html>
