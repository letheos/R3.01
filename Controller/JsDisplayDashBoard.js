/**
 * @autor loïck morneau
 */
//TODO la value du bouton ne change pas
/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */

function showAlert(button) {
    var confirmation = window.confirm("Voulez-vous supprimer ce candidat ?");
    if (confirmation) {
        var candidateId = button.getAttribute("data-id");

        // Récupérer le champ de formulaire caché pour l'ID du candidat
        var candidateIdInput = document.getElementById('candidateId');
        candidateIdInput.value = candidateId;

        // Soumettre le formulaire
        document.getElementById('delete-form').submit();
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

