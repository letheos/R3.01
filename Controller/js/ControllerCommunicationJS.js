function modifOn(Id){
    var boutonContainer = document.getElementById("bouton_" + Id);
    var modifier = boutonContainer.querySelector("#Modify");
    var valider = boutonContainer.querySelector("#Validate");
    if (modifier) modifier.style.display = "none";

    if (valider) valider.style.display = "block";
}

function modifOff(Id){
    var ladiv = document.getElementById("bouton_"+Id);
    var modifier = ladiv.querySelector("#Modify");
    var valider = ladiv.querySelector("#Validate");
    modifier.style.display = "block";
    valider.style.display = "none";
}

function checkIfModifierHidden() {
    // Récupérer tous les éléments avec la classe "buttonSubmit"
    var elements = document.querySelectorAll('.buttonSubmit');

    // Parcourir tous les éléments pour vérifier si un élément "Modifier" est en mode masqué
    for (var i = 0; i < elements.length; i++) {
        var modifier = elements[i].querySelector("#Modify");
        if (modifier && modifier.style.display === "none") {
            // Il y a un élément "Modifier" en mode masqué
            return true;
        }
    }

    // Aucun élément "Modifier" n'est en mode masqué
    return false;
}
function isContentAnImage(Id) {
    var messageDiv = document.getElementById(Id);
    var content = messageDiv.innerHTML.trim();
    var isImage = content.startsWith('<img')
    return isImage;
}

function transformToTextarea(Id) {
    var messageDiv = document.getElementById(Id);

    if (messageDiv !== null && !checkIfModifierHidden() && !isContentAnImage(Id)) {
        // Enregistre le texte original dans une variable
        var originalText = messageDiv.innerText;

        var textarea = document.createElement('textarea');
        textarea.name = 'la';
        textarea.value = originalText;
        textarea.id='letexte';

        // Ajoute un champ hidden avec le texte original
        var originalHidden = document.createElement('input');
        originalHidden.type = 'hidden';
        originalHidden.name = 'la';

        // Replace le contenu existant avec la textarea et le champ hidden
        messageDiv.innerHTML = '';

        messageDiv.appendChild(textarea);
        messageDiv.appendChild(originalHidden);

        modifOn(Id);
    } else {
        console.error('Element with ID ' + Id + ' not found.');
    }
}


function executerFormulaire(Id) {
    var texte = document.getElementById('letexte').value;
    var formulaire = document.getElementById(Id);

    // Récupérer le champ hidden "la" dans le contexte du formulaire
    var originalHidden = formulaire.querySelector('input[name="la"]');

    // Mettre à jour la valeur du champ hidden avec le texte modifié
    if (originalHidden) {
        originalHidden.value = texte;
    }

    // Soumettre le formulaire
    formulaire.submit();
}