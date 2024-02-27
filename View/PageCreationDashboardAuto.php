<?php ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<header class="jumbotron text-center bg-custom text-white">
    <form action="PageAccueil.php">
        <h1 class="TexteProfil">
            Affichage des tableaux de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil">Retour à l'accueil</button>
    </form>

    <!-- Ajout d'un espace vertical entre les deux formulaires -->
    <div class="mb-2"></div>

    <form action="PageAfficheTableau.php">
        <button class="btn btn-light mb-2">Retourner voir les autres tableaux de bords</button>
    </form>

    <form action="PageCreationDashboardAuto.php">
        <button class="btn btn-light mb-2">Créer un tableau de bord par default</button>
    </form>

</header>

<section id="objet creation">
    <h1>
        Tableau de bord par default
    </h1>

    <div class="rounded-box p-3 mb-4">
        <form method="post">
        <label for="Informatique">Formation en informatique</label>
        <input id="Informatique" type="checkbox">
        <label for="GIM">Génie industriel et maintenance (GIM)</label>
        <input id="GIM" type="checkbox">
        <label for="GEII">Génie électrique et informatique industrielle(GEII)</label>
        <input id="GEII" type="checkbox">
        <label for="GMP">Génie mécanique et productique(GMP)</label>
        <input id="GMP" type="checkbox">
        <label for="GEA">Gestion des entreprises et administrations (GEA)</label>
        <input id="GEA" type="checkbox">
        <label for="MP">Mesure Physique</label>
        <input id="MP" type="checkbox">
        <label for="QLIO">Qualité, logistique industrielle et organisation</label>
        <input id="QLIO" type="checkbox">
        <label for="TechniquesDeCommercialisation ">Techniques de commercialisation</label>
        <input id="TechniquesDeCommercialisation " type="checkbox">

            <button id="validerMultiDash" type="submit">valider</button>
        </form>
    </div>
</section>


<footer class="bg-custom text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div>
                    <p>
                        Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div>
                    <p>
                        2023/2024 UPHF
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
