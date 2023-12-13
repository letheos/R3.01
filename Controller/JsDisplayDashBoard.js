/**
 * @autor loick morneau
 */

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

