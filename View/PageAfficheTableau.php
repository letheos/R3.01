<?php

require_once "../Model/ModelCreationTableau.php";
?>
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

<header class="banner">
    <form>
        <h1 class="TexteProfil">
            Création de tableau de bord
        </h1>
        <button class="btn btn-light" type="submit" name="retourAccueil"
                onclick="window.location.href='PageAccueil.php'">Retour à l'accueil
        </button>
    </form>
</header>

</body>
</html>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="StylePageCreationTableau.css">
    <title>Document</title>
</head>
<body>
<p> yao zebe</p>

<?php

$conn = require "../Model/Database.php";

$test = getStudentsWithConditions(1,1,"1er","a",'a',$conn);


foreach ($test as $student) {

    echo $student[1] . "<br>";
    echo $student[2] . "<br>";
    echo $student[3] . "<br>";
    echo $student[4] . "<br>";
    echo $student[5] . "<br>";
    echo $student[6] . "<br>";
    echo $student[7] . "<br>";
    echo $student[8] . "<br>";
    echo $student[9] . "<br>";
    echo $student[10] . "<br>";
    echo $student[11] . "<br>";
    echo $student[12] . "<br>";
    echo $student[13] . "<br>";
    echo $student[14] . "<br>";
    echo $student[14] . "<br>";
    echo "<br>";
    echo "<br>";
}

?>


<footer>
    <div class="nomFooter">
        <p>
            Timothée Allix, Nathan Strady, Theo Parent, Benjamin Massy, Loïck Morneau

        </p>
    </div>
    <div class="origineFooter">
        <p>
            2023/2024 UPHF
        </p>
    </div>
</footer>

</body>
</html>


