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
    let buttonAddFormation = document.getElementById('addFormation');
    let buttonDelParams = document.getElementById('delParams');
    const formSettings = document.getElementById('settingsData');



// Mettre à jour la valeur initiale
    valeurOutput.innerHTML = slider.value;

// Définir un événement pour détecter les changements de la valeur du slider
    slider.addEventListener("input", function() {
        valeurOutput.innerHTML = this.value;

    });
    function addBlcockFormation(){
        if(blocCount < maxBlocs){
            const newSection = document.createElement("div");
            newSection.className = "newBlocFormation";
            newSection.innerHTML = `<p>Bloc ${blocCount + 1}</p><button class="supprimerBloc">Supprimer</button>`;
            newSection.innerHTML = `
        <p>Bloc ${blocCount + 1}</p>
        
        <button class="delBlock">Supprimer</button>
       

            <div class="menuDeroulFormation">
                <label for="formations">formation :</label>
                <select name="formations" title="formations" id="formations" multiple="multiple">

                    <option value="allFormations" selected>touts les parcours</option>
                    <?php
                    $parcours = controllerGetAllFormations();
                    foreach ($parcours as $parcour){ ?>
                    <option value="<?= $parcour[0] ?>"><?= $parcour[0] ?></option>
                    <?php } ?>
                </select>
            </div>

        <br>
            <div class="menuDeroulParcours">
                <label for="parcours">Parcours de l'étudiant</label>
                <select name="parcours" title="parcours" id="parcours">
                    <option value="allParcours" selected>tous les parcours</option>
                   
                    <?php
                    $parcours = controllerGetAllParcours();
                    foreach ($parcours as $parcour){ ?>
                        <option value="<?= $parcour[0] ?>"><?= $parcour[0] ?></option>
                    <?php } ?>on>parcours C</option>
                </select>
            </div>
        <br>
         

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
    buttonAddFormation.addEventListener('click', addBlcockFormation);
    document.getElementById('addFormation').addEventListener('click', addBlcockFormation);

})


function réduitParam(){


}
