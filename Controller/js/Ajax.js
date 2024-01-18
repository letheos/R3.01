function onChangeUpdateDisplayParcours(link, selectedFormation, selectedParcours) {

    var selectedFormation = document.getElementById("formation").value;
    var parcoursSelect = document.getElementById("parcours");
    //Initialisation de la requête
    var xhr = new XMLHttpRequest();


    xhr.onreadystatechange = function(){
        if (this.readyState === 4 && this.status === 200  ){
            // Efface toutes les options actuelles de la liste déroulante
            parcoursSelect.innerHTML = "";

            // Récupère les données JSON renvoyées par le serveur
            var parcoursData = this.response;
            console.log(parcoursData);

            var option = document.createElement("option");
            option.setAttribute("value", "");
            option.text = "Choisir le parcours";
            option.selected = true;
            option.disabled = true;
            parcoursSelect.appendChild(option);

            // Remplit la liste déroulante avec les options de parcours
            parcoursData.forEach(function (parcours)
            {
                var option = document.createElement("option");
                option.value = parcours.nameParcours;
                option.text = parcours.nameParcours;
                if (parcours.nameParcours == selectedParcours){
                    option.selected = true;
                }

                parcoursSelect.appendChild(option);
            });



        } else if (this.readyState === 4) {
            alert(console.log(this.response));

        }
    };
    xhr.open("POST", link, true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({ formation: selectedFormation }));

    return false

}

