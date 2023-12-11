/**
 * @autor loick morneau
 */

/**
 * try to show or hide the element in the div elementCacher (nom provisiore)
 */
function affiche(){
    var divCacher = document.getElementById("elementCacher")
    var button = document.getElementById("buttonShowhide")

    if(divCacher.style.display == "none"){
        divCacher.style.display = "block"
        button.innerText("-")
    } else{
        divCacher.style.display = "none"
        button.innerText("+")
    }
}