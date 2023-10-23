/**
 * Fichier js qui gère l'ajout et la suppression de champs dans la page Creation pageCreationTableau
 * @author Loïck Morneau
 * */

//Variable générale nécessaire pour la récupération de certaine donnée et l'initialisation des compteurs
const limitChamp = 4;

document.addEventListener("DOMContentLoaded", function (){
    var slider = document.getElementById("myRange");
    var valeurOutput = document.getElementById("valeurSlider");

// Mettre à jour la valeur initiale
    valeurOutput.innerHTML = slider.value;

// Définir un événement pour détecter les changements de la valeur du slider
    slider.addEventListener("input", function() {
        valeurOutput.innerHTML = this.value;
    });
})

function addAdress(){
    if(nbChampAdress < limitChamp){
        const newDiv = document.createElement("div");
        newDiv.className = "truc";

        newDiv.innerHTML = `
            <div id="city"> ville
                <label for="city">
                    <select name="city">
                        <option value="Lille">Lille</option>
                        <option value="Valenciennes">Valenciennes</option>
                    </select>
                </label>
            </div>

            <div class="slidecontainer" >
                <label for="myRange">Distance de recherche :</label>
                <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                <p> : <span id="valeurSlider">50</span></p>
                <p>km</p>
        </div>
        `;
    }
}
