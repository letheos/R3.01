/**
 * Fichier js qui gère l'ajout et la suppression de champs dans la page Creation pageCreationTableau
 * @author Loïck Morneau
 * */

//TODO mettre le nom en glaouche de mettreEnEcouteSuppression
//+

//Variable générale nécessaire pour la récupération de certaine donnée et l'initialisation des compteurs
let blocCount = 1;
const maxBlocs = 4;

document.addEventListener("DOMContentLoaded", function (){
    let slider = document.getElementById("myRange");
    let valeurOutput = document.getElementById("valeurSlider");
    //valeur pour ajouter un Blocs de paramètres
    let buttonAddParams = document.getElementById('addParmas');
    let buttonDelParams = document.getElementById('delParams');
    const formSettings = document.getElementById('settingsData');



// Mettre à jour la valeur initiale
    valeurOutput.innerHTML = slider.value;

// Définir un événement pour détecter les changements de la valeur du slider
    slider.addEventListener("input", function() {
        valeurOutput.innerHTML = this.value;

    });
    function addBlocParams(){
        if(blocCount < maxBlocs){
            const newSection = document.createElement("section");
            newSection.className = "newBlocParams";
            newSection.innerHTML = `<p>Bloc ${blocCount + 1}</p><button class="supprimerBloc">Supprimer</button>`;
            newSection.innerHTML = `
        <p>Bloc ${blocCount + 1}</p>
        <button class="delBlock">Supprimer</button>
        <section class="settingsData" id="settingsData">
            <form class="parametre" method="post" action="../Controller/controllerCreationTableau.php">
            <h2> Paramètres des données à afficher dans le tableau de bord</h2>
           <!-- section générale des paramètre de données -->

            <div class="menuDeroulFormation">
                <label for="formations">formation :</label>
                <select name="formations" title="formations" id="formations">
                    <!-- faire un script js qui ajoute multiple -->
                    <option value="allFormations" selected>toutes les formations</option>
                    <option value="but info">but informatique</option>
                </select>
            </div>

        <br>

            <div class="menuDeroulAnnee">
                <label for="formAnnee"> Année </label>
                <select name="formAnnee" title="formAnnee" id="formAnnee">
                    <option value="all" selected>toutes les années</option>
                    <option value="1">1er</option>
                    <option value="2">2e</option>
                    <option value="3">3e</option>
                </select>
            </div>

        <br>


            <div class="menuDeroulParcours">
                <label for="parcours">Parcours de l'étudiant</label>
                <select name="parcours" title="parcours" id="parcours">
                    <option value="allParcours" selected>tous les parcours</option>
                    <option>parcours A</option>
                    <option>parcours B</option>
                    <option>parcours C</option>
                </select>
            </div>
        <br>



            <div class="menuDeroulActif">
                <label for="idActif">Etudiant actif ?</label>
                <select name="isActif" title="isActif" id="idActif">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>


        <div class="menuDeroulPermis">
            <label for="idPermis">Permis</label>
                <select name="isPermis" title="isPermis" id="idPermis">
                    <option value="1">oui</option>
                    <option value="0">non</option>
                </select>
            </div>



            <div class="cityForm">
                <label for="city"> Ville </label>
                    <select name="city" id="city">
                        <option value="allCity">toutes les villes</option>
                        <option value="Lille">Lille</option>
                        <option value="Valenciennes">Valenciennes</option>
                    </select>

            </div>

            <div class="slidecontainer">
                <label for="myRange">Distance de recherche :</label>
                <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                <p>Distance en km : <span id="valeurSlider">50</span></p>

            </div>
        
            <div class="addParams">
                <label for="addParmas"> Ajouter une page de paramètres</label>
                <button type="button" name="addParmas" id="addParmas" >+</button>
                <p>nombre de paramètres <span id="nuberSettingsData">1/4</span></p>
            </div>
            
            <div class="delParams">
            <label for="deleteButton">supprimer une page de paramètres</label>
                <button type="button" name="deleteButton" id="deleteButton">-</button>
            </div>
        
            </form>
        </section>
        `;
            formSettings.appendChild(newSection);
            blocCount++;
            mettreEnEcouteSuppression(newSection);
        }else{
            alert("Vous avez atteint le nombre maximum de blocs (4).")
        }
    }
    function delBloc(bloc) {
        formSettings.removeChild(bloc);
        blocCount--;
    }
    //mettre le nom en glaouche
    function mettreEnEcouteSuppression(bloc) {
        const buttondelete = bloc.querySelector('.delBlock');
        buttondelete.addEventListener('click', function () {
            delBloc(bloc);
        });
    }
    buttonAddParams.addEventListener('click', addBlocParams);
    document.getElementById('addParmas').addEventListener('click', addBlocParams);

})


function réduitParam(){


}
