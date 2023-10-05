<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="PageCreationcss.css">
    <title>Document</title>
    <?php session_start();
    include "../Controller/ControllerCreation.php";?>

</head>

<body>

<div class="rounded-box">
    <form action="../Controller/ControllerCreation.php" method="POST">
        <label for="lastName">Nom</label>
        <input type="text" name="lastName" value="<?php echo isset($_SESSION['lastName']) ? $_SESSION['lastName'] : ''; ?>">
        <br>
        <br>
        <label for="firstName">Prenom</label>
        <input type="text" name="firstName" value="<?php echo isset($_SESSION['firstName']) ? $_SESSION['firstName'] : ''; ?>"><br>
        <br>
        <label for="mail">mail</label>
        <input type="email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>"> <br>
        <br>
        <label for="login">Login</label>
        <input type="text" name="login" value="<?php echo isset($_SESSION['login']) ? $_SESSION['login'] : ''; ?>">
        <br>
        <br>
        <label for="formation">formation</label>
        <select name="menu" size="1">
            <option>mph</option>
            <option>BUT informatique</option>
        </select>
        <br>
        <br>
        <label for="role">Rôle</label>
        <select name="role" size="1">
            <option value="Secretaire">Secrétaire</option>
            <option value="Chefdep">Chef de département</option>
            <option value="Chargedev">Chargé de développement</option>
        </select>
        <div id="password">
            <br>
            <label for="password">mot de passe</label>
            <input type="password" name="pswd">
            <div class="info-bubble">
                Le mot de passe doit contenir au moins 8 caractères, un chiffre et un caractère spécial (excepté " ' et ;).
            </div>
        </div>
        <br>
        <label for="confirmation">confirmation mot de passe </label>
        <input type="password" name="confirmation">
        <br>
        <button name="envoyer" class="btn btn-outline-primary" type="submit">inscription</button>
        <?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    if ($message === "Enregistré avec succès") {
        ?>
        <div class="alert alert-success">
            <?php
            } else {
            ?>
            <div class="alert alert-danger">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</div>
</body>


</html>
