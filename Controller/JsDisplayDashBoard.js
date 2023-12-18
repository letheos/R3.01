/**
 * @autor loïck morneau
 */
//TODO la value du bouton ne change pas
/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */

function afficherAlerte() {
    var resultat = window.confirm("Voulez-vous continuer ?");

    // Vérifier le résultat de l'alerte
    if (resultat) {
        // L'utilisateur a cliqué sur "OK"
        alert("Vous avez choisi de continuer.");
    } else {
        // L'utilisateur a cliqué sur "Annuler"
        alert("Vous avez choisi d'annuler.");
    }
}

function changeDisplay(id){
    var divCacher = document.getElementById(id);

    var hide = document.getElementById('btnChangeDisplay'+id);


    if(divCacher.style.display === "none"){
        divCacher.style.display = "block";
        hide.value = '-';

    } else{
        divCacher.style.display = "none";
        hide.value = '+';

    }
}

