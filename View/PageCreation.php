<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="PageCreationcss.css">
    <script ref = ></script>
    <title>Document</title>

    <script src = "../Controller/jsCreation.js"></script>
    <?php session_start();
    include '../Controller/ControllerCreation.php';
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $conn = require '../Model/Database.php';
    ?>
</head>

<body>
<div class="rounded-box">
    <section name = "formInscription">
    <form action="../Controller/ControllerCreation.php" method="POST">

        <!-- création du formulaire-->
        <div name = "divNom">

        <!-- partie nom de l'inscription -->
        <label for="lastName">Nom</label>
        <input type="text" name="lastName" value="<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : ''; ?>">
        </div>
        <br>


        <!-- partie prénom de l'inscription-->
        <div name="divPrenom">
        <label for="firstName">Prenom</label>
        <input type="text" name="firstName" value="<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : ''; ?>"><br>
        </div>
        <br>

        <!--partie e mail de l'inscription-->
        <div name="divEmail">
        <label for="mail">Mail</label>
        <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"> <br>
        </div>
        <br>


        <!--partie identifiant de l'inscription-->
        <div name="divLogin">
        <label for="login">Login</label>
        <input type="text" name="login" value="<?php echo isset($_SESSION['login']) ? $_SESSION['login'] : ''; ?>">
        </div>
        <br>


        <!--partie role de l'inscription-->
        <div name="divRole">
        <label for="role">Rôle</label>
        <select  id="idRole" name="selectRole" size="1"  value="<?php echo isset($_SESSION['selectRole']) ? $_SESSION['selectRole']:'' ?>">
            <option id="idSecretaire" value=2>Secrétaire</option>
            <option id="idChefDepartement" value=1 >Chef de département</option>
            <option id="idChargeDev" value=3>Chargé de développement</option>
        </select>
        </div>

        <br>
        <label for="formation">Formation</label>
        <!--partie formation de l'inscription
    <div class = rounded-box id="formations">
        <div class="choices-container">
            <?php

            affichageRadioButton($conn);
            ?>
        </div>
        -->

        <div class = rounded-box2 id="formations">
            <div class="choices-container">

                <?php

                affichageRadioButton($conn);
                ?>

            </div>




        <div class=select-all-container">

            <label class="label-select-all">
                <input type="checkbox" id="select-all" name="select-all" > Sélectionner tout
            </label>
        </div>
    </div>

        <div id="divFormation" >

            <select  id="idFormation" name="selectFormation" size="1" style="display: none" value="<?php echo isset($_SESSION['selectFormation']) ? $_SESSION['selectFormation']:'' ?>">
                <?php

                displayformations($conn); ?>
            </select>
        </div>
        <br>
        <!--partie mot de passe de l'inscription-->
        <div name="divPassword">
            <label for="password">Mot de passe</label>
            <input type="password" name="pswd">
            <div class="info-bubble">
                <!--info bubble correspond a un menu qui apparait quand la souris passe au niveau du input-->
                Le mot de passe doit contenir au moins 6 caractères, un chiffre et un caractère spécial (excepté " ' et ;).
            </div>
        </div>

        <br>

        <!--partie confirmation de mot de passe de l'inscription-->
        <div name="divConfirmation">
        <label for="confirmation">Confirmation mot de passe </label>
        <input type="password" name="confirmation">
        </div>
        <br>
        <button  class="btn btn-outline-primary" name="buttonInscription" type="submit">inscription</button> <!--btn outline primary correspond à un bouton normal modifié par boostrap -->

        <?php

        //affichage du message en sortie selon les critères rentrés par l'utilisateur
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    if ($message === "Enregistré avec succès") {
        // si le message correspond à "Enregistré avec succès" alors on crée  une alert success qui génère une boite de couleur verte
        ?>
        <div  class="alert alert-success" name="messageSuccesInscription">
            <?php
            } else {
        //dans le cas ou le message est une erreur alors on crée une alert danger sui génère une boite de couleur rouge
        ?>

            <div  class="alert alert-danger" name="messageErreurInscription">
                <?php
                }
                if ($_SESSION['message'] != null) {
                    echo $_SESSION['message'];
                }
                ?>
            </div>
            <?php
            }
            ?>
    </form>
    </section>
            <!-- script de liaison a bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</div>
</body>

</html>
