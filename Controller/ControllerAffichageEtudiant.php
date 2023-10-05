<?php
$conn = require "../Model/Database.php";
function listAffichage($conn){
    $selected = '';
    $results = allFormation($conn);
    echo '<select class="form-select" name="formation" id="formation">',"\n";
    foreach($results as $row)
    {
        $selected = 'selected="selected"';
        echo "\t",'<option value="', $row['nameFormation'] ,'"', $selected ,'>', $row['nameFormation'] ,'</option>',"\n";
        $selected='';
    }
    echo '<option value="AucuneOption" selected="selected" > Aucune Option </option>';
    echo '</select>',"\n";
}

function choice($conn, $choixFormation){
    if ($choixFormation == "AucuneOption" || $choixFormation == null){
        $results = selectCandidats($conn);
        foreach($results as $row){
            echo '<p class="candidates"> INE : '.$row['INE']." ".$row['firstName']." ".$row['name']." ".$row['nameFormation'].'</p>';
        }
    }
}

