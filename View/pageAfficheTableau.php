<?php
require "../Model/modelCreationTableau.php";
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
<p> yao zebe</p>

<?php

$conn = require "../Model/database.php";

$test = getStudentsWithConditions(1,1,"1er","a",'a',$conn);
echo '<script> alert("21")</script>';

foreach ($test as $student) {

    echo $student[1] . "<br>";
    echo $student[2] . "<br>";
    echo $student[3] . "<br>";

}

?>
</body>
</html>

<?php
