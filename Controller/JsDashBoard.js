/**
 * @Author : Nathan Strady
 * Js de la page DashBoard
 */
/**
 *
 * @type {boolean} Gère l'affichage des checkboxes
 * Code repris du site : https://stackoverflow.com/questions/17714705/how-to-use-checkbox-inside-select-option
 */
var expanded = false;

function showCheckboxes(checkboxesElement) {
    var checkboxes = document.getElementById(checkboxesElement);
    if (!expanded) {
        checkboxes.style.display = "block"; 
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
}