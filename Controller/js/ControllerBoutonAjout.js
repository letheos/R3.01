const limitChamp = 4;
let nbChampAdress = 2;
let nbChampCitySearch = 2;
const divAdressForm = document.querySelector(".adressForm");
const divCityForm = document.querySelector(".cityForm");

/**
 * Fonction qui ajoute un champ en fonction de plusieurs paramètres
 * @param container La div où se trouve l'élement
 * @param name Le nom de l'élement
 * @param placeholder L'affichage dans le champ de l'élement
 * @param className Le type de classe de l'élement
 * @returns {HTMLInputElement} Renvoie le nouveau champs
 */
function addField(container, name, placeholder, className) {
    if (container) {
        const newField = document.createElement("input");
        newField.type = "text";
        newField.placeholder = placeholder;
        newField.name = name;
        newField.className = className;
        container.appendChild(newField);
        return newField;
    }
    throw new DOMException("Container doesn't exist");
}

/**
 * Ajout une adresse dans la div adressForm
 */
function addAdressInput() {
    if (nbChampAdress < limitChamp) {
        try {
            const nouvelInputAdress = addField(divAdressForm, "adress[]", "Adresse d'habitation " + nbChampAdress, "form-control");
            if (nouvelInputAdress) {
                nbChampAdress++;
            }
        } catch (error){
            console.error(error.message);
        }
    }
}

/**
 * Ajoute une div citySearch
 */
function addResearchZone(){

    var newDiv = document.createElement("citySearch" + nbChampCitySearch);

    newDiv.innerHTML = `
        <input type="text" class="form-control" name="citySearch[]" placeholder="Zone ${nbChampCitySearch}">
        <select class="form-select" name="searchZone[]">
            <option selected disabled>Choisir la mobilité</option>
            <option value="Seulement dans la ville">Seulement dans la Ville</option>
            <option value="Ville et Alentours">Ville et Alentours</option>
            <option value="Département">Département</option>
        </select>
    `;

    nbChampCitySearch++;


    // Ajoutez les nouveaux éléments clonés à la fin du formulaire
    divCityForm.appendChild(newDiv);

}

/**
 *
 * @param element Ceci est la balise pour lequel on supprime le dernier enfant
 * @returns {boolean} Renvoie si l'opération à réussie ou non.
 */
function delLastChild(element) {
    let firstChild = element.firstElementChild;
    let lastChild = element.lastElementChild;
    if (firstChild !== lastChild) {
        element.removeChild(lastChild);
        return true;
    }
    return false;
}

/**
 * Supprime le dernier enfant de la div adressForm
 */
function delAdressInput() {
    if(delLastChild(divAdressForm)) {
        nbChampAdress--;
    }
}

/**
 * Supprime le dernier enfant de la div cityForm
 */
function delReserchZone() {
    if(delLastChild(divCityForm)){
        nbChampCitySearch--;
    }
}