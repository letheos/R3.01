/**
 * Fichier js qui gère l'ajout et la suppression de champs dans la page Creation Candidat
 * @author Nathan Strady
 */

/**
 *
 * @type {number} : Variable d'initialisation des compteurs
 * @type {divAdressForm} Variable qui récupère la div cityForm
 * @type {divAdressForm} Variable qui récupère la div adressForm
 */

//Variable générale nécessaire pour la récupération de certaine donnée et l'initialisation des compteurs
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
        newField.required = true;
        container.appendChild(newField);
        return newField;
    }
    throw new DOMException("Container doesn't exist");
}

/**
 * Ajout une adresse complète dans la div adressForm
 */
function addCompleteAddress() {
    if (nbChampAdress < limitChamp) {
        try {
            const newDiv = document.createElement("div");
            newDiv.className = "adressFormTemplate";

            newDiv.innerHTML = `
                <div class="form-group">
                    <input class="form-control" type="text" name="cp[]" placeholder="Code Postal" required>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="address[]" placeholder="Adresse d'habitation" required size="50">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="cityCandidate[]" placeholder="Ville" required>
                </div>
            `;

            // Ajoutez la nouvelle adresse complète à la div adressForm
            divAdressForm.appendChild(newDiv);

            nbChampAdress++;
        } catch (error) {
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
        <input type="text" class="form-control" name="citySearch[]" placeholder="Zone ${nbChampCitySearch}" required>
        <label for="rayon">Rayon :</label>
        <input type="number" id="rayon" name="rayon[]" min="0" step="1" required>
        <span>Km</span>
        `;

    nbChampCitySearch++;


    // Ajoutez les nouveaux éléments clonés à la fin du formulaire
    divCityForm.appendChild(newDiv);

}

/**
 * Fonction supprimant le dernier enfant d'une balise div
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



