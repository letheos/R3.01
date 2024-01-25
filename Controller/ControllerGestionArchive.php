<?php
/**
 * @author Timothée Allix
 */


/**
 * @param $infos String[] Contient les différents candidats
 * @return void Créer une archive ZIP contenant tout les cvs des candidats
 */
function dlArchive($infos)
{
    global $conn;
    $val = array();
    foreach ($infos as $candidat) {
        $val[] = selectCandidatById($conn,$candidat);
    }
    $archivePath = createImageArchive($val,"cv.zip");
    if (file_exists($archivePath)) {
        ob_end_clean();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="cvs.zip"');
        header('Content-Length: ' . filesize($archivePath));

        readfile($archivePath);

        unlink($archivePath);
    } else {
        die("Impossible de trouver l'archive.");
    }
}

function createImageArchive($userandcv, $outputArchiveName) {

    global $conn;
    $zip = new ZipArchive();
    if ($zip->open($outputArchiveName, ZipArchive::CREATE) !== TRUE) {
        die ("Impossible de créer l'archive");
    }

    foreach ($userandcv as $val){
        if($val['cv']!= null and $val['cv']!="") {
            $imageId = $val['name'] . $val['firstName']."." . pathinfo($val['cv'], PATHINFO_EXTENSION);
            $imagePath = $val['cv'];
            echo $imageId . ":" . $imagePath;
            $zip->addFile($imagePath,$imageId);
        }
    }

    $zip->close();
    return $outputArchiveName;
}
