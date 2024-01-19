/**
 * @autor loïck morneau
 */
//TODO la value du bouton ne change pas
/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */

function showAlert(button,id) {
    alert('validation'+id)
    var confirmation = window.confirm("Voulez-vous supprimer ce candidat ?");
    if (confirmation) {
        var validation = document.getElementById('validation'+id);
        validation.value = '1';
        alert(validation.value);
        //document.getElementById('deleteForm'+id).submit();

    }else{
        var validation = document.getElementById('validation'+id)
        validation.value = '0';
        alert(validation.value);
        //document.getElementById('deleteForm'+id).submit();
    }
}


/**
 *
 * @param id String
 * hide or show the values that à dashbaord
 */
function changeDisplay(id) {
    var divCacher = document.getElementById(id);
    var hide = document.getElementById('btnChangeDisplay' + id);
    var card = divCacher.closest('.card');
    var cardBody = divCacher.closest('.card-body');

    if (divCacher.style.display === "none") {
        divCacher.style.display = "block";
        hide.value = '-';
        card.classList.remove('collapsed');
    } else {
        divCacher.style.display = "none";
        hide.value = '+';
        card.classList.add('collapsed');
    }
}

