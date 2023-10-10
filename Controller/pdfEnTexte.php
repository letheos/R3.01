<?php
$pdfFilePath = 'C:\MAMP\htdocs\R3.01\poubelle'; // Remplacez par le chemin de votre fichier PDF
$outputTextFilePath = 'fichier_texte.txt'; // Le fichier texte de sortie

$fileContents = file_get_contents($pdfFilePath);
$byteArray = str_split($fileContents);
$byteArray = unpack('C*', $fileContents);

