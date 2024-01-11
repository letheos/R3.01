function onChangeUpdateDisplayMultiple(link, data) {
    var selectedFormationElement = document.getElementById("formation");
    var selectedFormation = selectedFormationElement.options[selectedFormationElement.selectedIndex].value;

    // For checkboxes
    var checkboxes = document.getElementsByName("formation[]");
    var selectedCheckboxes = Array.from(checkboxes).filter(function (checkbox) {
        return checkbox.checked;
    }).map(function (checkbox) {
        return checkbox.value;
    });

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var parcoursContainer = document.getElementById("checkboxesParcours");
            var parcoursData = this.response;

            // Clear existing checkboxes
            parcoursContainer.innerHTML = "";
            console.log(parcoursData);

            // Create checkboxes based on parcoursData
            parcoursData.forEach(function (parcours) {
                var label = document.createElement("label");
                label.for = parcours.nameParcours;

                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "parcours[]";
                checkbox.value = parcours.nameParcours;

                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(parcours.nameParcours));

                parcoursContainer.appendChild(label);
            });
        } else if (this.readyState === 4) {
            console.error("Error in AJAX request:", this.response);
            // Handle the error as needed
        }
    };

    xhr.open("POST", link, true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({ formations: selectedCheckboxes, parcours: data }));

    return false;
}
