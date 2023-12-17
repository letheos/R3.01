/**
 * @autor loïck morneau
 */
//TODO la value du bouton ne change pas
/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */



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

