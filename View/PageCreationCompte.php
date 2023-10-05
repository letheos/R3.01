<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../Model/PageCreationcss.css">
    <title>Document</title>
</head>
<body>
<div class="rounded-box">


    <form action="PageCreationCompte.php" method="post">
        <label for="INE">INE</label>
        <input type="text" name="INE" placeholder="123456789AB" pattern = "\d{9}[A-Za-z]{2}" value="<?php echo isset($_POST['INE']) ? $_POST['INE'] : ''; ?>">
        <label>Un INE est composé de 9 chiffres et 2 lettres </label>
        <br>
        <br>
        <label for="lastName">Nom de l'étudiant</label>
        <input type="text" name="lastName" placeholder="nom" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
        <br>
        <br>
        <label for="firstName">Prenom</label>
        <input type="text" name="firstName" placeholder="Prénom"
               value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>"><br>
        <br>
        <label for="adresse">Adresse</label>
        <input type="text" name="address" placeholder="rue ville code postal" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>"><br>
        <br>
        <label for="phoneNumber">numéro de téléphone</label>
        <input type="tel" name="phoneNumber" placeholder="01 23 45 67 89" pattern="[0-9]{10}" value="<?php echo isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : ''; ?>"> <br>
        <br>
        <label for="Ville">Ville</label>
        <input type="text" name="Ville"
               value="<?php echo isset($_POST['Ville']) ? $_POST['Ville'] : ''; ?>">
        <label> (latitude, longitude)</label>
        <br>
        <br>
        <label for="radius">rayon</label>
        <input type="range" min="1" max="100" name="radius"
               value="<?php echo isset($_POST['radius']) ? $_POST['radius'] : ''; ?>">
        <label>minimum = 1 maximum = 100</label>
        <br>
        <br>

        <label for="typeEntrepriseRecherche">type des entreprises recherchées</label>
        <input type="text" name="typeEntreprises"
               value="<?php echo isset($_POST['typeEntreprises']) ? $_POST['typeEntreprises'] : ''; ?>"><br>
        <br>


        <label for="formation">formation</label>
        <select name="formation" size="1">
            <!--check la bdd pour éviter d'avoir des erreurs de formations -->
            <!-- faire le code pour avoir automatiquement les formations -->
            <option value="2">mph</option>
            <option value="1" >BUT informatique</option>
        </select>
        <br>
        <br>
        <label for="permisB">permisB</label>
        <select name="permisB" size="1">
            <option value="false">non</option>
            <option value="true" >oui</option>
        </select>
        <br>
        <br>
        <label for="cv">inserer le cv ici</label>
        <input type="file" name="cv" value="<?php echo isset($_POST['cv']) ? $_POST['cv'] : ''; ?>" accept=".pdf"><br>
        <br>>

        <button name="envoyer" class="btn btn-outline-primary" type="submit">inscription</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"></script>

    <?php


    if (isset($_POST['envoyer'])) {
        // Récupération des valeurs du formulaire
        $INE = strtoupper($_POST['INE']);
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $address = $_POST['address'];
        $ville = $_POST['Ville'];
        $formation = intval($_POST['formation']);
        $typeEntrepriseRecherche = $_POST['typeEntreprises'];
        $permisB = $_POST['permisB'];
        $cv = $_POST['cv'];
        $coord = $_POST['Ville'];
        $radius = $_POST['radius'];
        $actif = true;
        $phoneNumber = $_POST['phoneNumber'];



        if (preg_match('/[^A-Za-z0-9"\';]/', $lastName
        )) {
            echo('<div class="alert alert-warning" role="alert">
        le nom contient un caractère spécial
      </div>');
        } elseif (preg_match("/[0-9]/", $lastName
        )) {
            echo('<div class="alert alert-warning" role="alert">
                le nom contient un chiffre
          </div>');
        } elseif (preg_match('/[^A-Za-z0-9"\';]/', $firstName
        )) {
            echo('<div class="alert alert-warning" role="alert">
        le prénom contient un caractère spécial
      </div>');
        } elseif (preg_match("/[0-9]/", $firstName
        )) {
            echo('<div class="alert alert-warning" role="alert">
                le prénom contient un chiffre
          </div>');
        } elseif (preg_match('/^\d{9}[A-Z-a-z]{2}$/', $INE)) {
            // L'INE n'est pas valide
            echo('<div class="alert alert-warning" role="alert">
                Un INE est composé de 9 chiffres suivie de 2 lettres
            </div>');
        }elseif (
            $firstName == null || $lastName == null || $INE == null || $formation == null || $formation == null || $coord == null) {
            echo('<div class="alert alert-warning" role="alert">
        tout les champs de texte doivent être remplis
        </div>');

        }


        //TODO adapter la bdd pour remettre la formation en clé étrangére et faire le code pour avoir automatiquement les formations

        $bdd = require "../Model/Database.php";

        $sql = "insert into students values (?,?,?,?,?,?,?,?,?,true);";

        $req = $bdd->prepare($sql);
        $req->bindValue(1, $INE);
        $req->bindValue(2, $lastName);
        $req->bindValue(3, $firstName);
        $req->bindValue(4, $address);
        $req->bindValue(5, $ville);
        $req->bindValue(6, $radius);
        $req->bindValue(7,$permisB);
        $req->bindValue(8, $formation);
        $req->bindValue(9, $typeEntrepriseRecherche);

        $req->execute();
        //a
    }

    ?>
</div>
</body>
</html>