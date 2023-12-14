/**
 * @autor loïck morneau
 */
//TODO la value du bouton ne change pas
/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */

function affiche(){
    var divCacher = document.getElementById("elementCacher")

    let cache = document.getElementById('btnCache');

    if(divCacher.style.display == "none"){
        divCacher.style.display = "block"
    } else{
        divCacher.style.display = "none"
    }
    if (cache.value == '-')
        cache.value = '+'
    else
        cache.value = '-'
}

function changeDisplay(id){
    var divCacher = document.getElementById(id)

    let hide = document.getElementById('btnCache'.id);


    if(divCacher.style.display === "none"){
        divCacher.style.display = "block"
    } else{
        divCacher.style.display = "none"
    }
    if (hide.value === '-')
        hide.value = '+'
    else
        hide.value = '-'
}

