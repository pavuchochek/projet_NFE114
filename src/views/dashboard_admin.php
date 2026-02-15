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
    <div id="admin-dashboard">

        <section id="stats-cours" class="stats-section theme-blue" >
            <h2>Cours</h2>
            <div class="stats-grid" id="cours-container"></div>
        </section>

        <section id="stats-coachs" class="stats-section theme-green">
            <h2>Coachs</h2>
            <div class="stats-grid" id="coachs-container"></div>
        </section>

        <section id="stats-adherents" class="stats-section theme-purple">
            <h2>Adhérents</h2>
            <div class="stats-grid" id="adherents-container"></div>
        </section>

        <section id="stats-salles" class="stats-section theme-orange">
            <h2>Salles</h2>
            <div class="stats-grid" id="salles-container"></div>
        </section>

        <section id="stats-prix" class="stats-section  theme-red">
            <h2>Paiements coachs</h2>
            <div id="prix-container"></div>
        </section>

    </div>
</div>

<script src="/assets/js/dashboard_admin.js" type="module" defer></script>
<script src="/assets/js/general.js" defer></script>
</body>
</html>
