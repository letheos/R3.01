
document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll('input[name="formation[]"]:checked');
    checkboxes.forEach(function(checkbox) {
        onChangeUpdateDisplayMultiple('../Controller/ControllerDashboardAjax.php', data, selectedParcours);
    });
});

var checkboxes = document.querySelectorAll('input[name="formation[]"]');
checkboxes.forEach(function(checkbox) {
    checkbox.addEventListener("change", function() {
        if (this.checked) {
            onChangeUpdateDisplayMultiple('../Controller/ControllerDashboardAjax.php', data, selectedParcours);
        }
    });
});

function onChangeUpdateDisplayMultiple(link, data, selectedParcours) {
    var selectedFormationElement = document.getElementById("formation");
    var selectedFormation = selectedFormationElement.options[selectedFormationElement.selectedIndex].value

    // For checkboxes
    var checkboxes = document.getElementsByName("formation[]");
    var selectedCheckboxes = Array.from(checkboxes).filter(function (checkbox) {
        return checkbox.checked;
    }).map(function (checkbox) {
        return checkbox.value;
    });

    console.log(data);
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            var parcoursContainer = document.getElementById("checkboxesParcours");
            var parcoursData = this.response;
            console.log(this.response);


            // Clear existing checkboxes
            parcoursContainer.innerHTML = "";

            // Create checkboxes based on parcoursData
            parcoursData.forEach(function (parcours) {
                var label = document.createElement("label");
                label.for = parcours.nameParcours;

                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.name = "parcours[]";
                checkbox.value = parcours.nameParcours;

                // Check the checkbox if it's in the selectedParcours array
                if (selectedParcours.includes(parcours.nameParcours)) {
                    checkbox.checked = true;
                }

                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(parcours.nameParcours));

                parcoursContainer.appendChild(label);
            });
        } else if (this.readyState === 4) {
            console.error("Error in AJAX request:", this.response);
        }
    };

    xhr.open("POST", link, true);
    xhr.responseType = "json";
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.send(JSON.stringify({ formations: selectedCheckboxes, parcours: data }));

    return false;
}