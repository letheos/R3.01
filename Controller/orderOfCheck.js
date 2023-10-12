const formationList = document.getElementById("formation-list");
const formationCheckboxes = document.querySelectorAll(".choices-formation");
const formationCheckboxeAll = document.getElementById("select-all");
let dragFormation = null;

function checkAll(){
    formationCheckboxeAll.addEventListener('change', function (event) {
        let isChecked = this.checked;
        formationCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateFormationList();
    });
}

function updateFormationList() {
    formationList.innerHTML = ""; // Efface la liste actuelle
    formationCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            const formationId = checkbox.id;
            const formationName = checkbox.value;
            const formationItem = document.createElement("li");
            formationItem.id = formationId;
            console.log(formationItem.id);
            formationItem.draggable = true;
            formationItem.textContent = formationName;
            formationList.appendChild(formationItem);
        }
    });
}

formationCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", updateFormationList);
});

formationList.addEventListener("dragstart", e => {
    dragFormation = e.target;
    e.dataTransfer.setData("text/plain", e.target.innerHTML);
})

formationList.addEventListener("dragover", e => {
    e.preventDefault();
});

formationList.addEventListener("drop", e => {
    e.preventDefault();
    if (e.target.tagName === "li") {

        e.target.innerHTML = dragFormation.innerHTML;
        dragFormation.innerHTML = e.dataTransfer.getData("text/plain");
    }
    dragFormation = null;

});
formationList.addEventListener("dragend", e => {
    dragFormation = null;
});


checkAll();
updateFormationList();


