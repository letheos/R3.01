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

function transformToTextarea(Id) {
    var messageDiv = document.getElementById(Id);

    if (messageDiv !== null) {
        // Enregistre le texte original dans une variable
        var originalText = messageDiv.innerText;

        var textarea = document.createElement('textarea');
        textarea.name = 'modifiedMessage';
        textarea.value = originalText;
        textarea.id='letexte';

        // Ajoute un champ hidden avec le texte original
        var originalHidden = document.createElement('input');
        originalHidden.type = 'hidden';
        originalHidden.name = 'la';

        // Replace le contenu existant avec la textarea et le champ hidden
        messageDiv.innerHTML = ''; // Supprime tous les enfants

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
    var originalHidden = document.createElement('input');
    originalHidden.type = 'hidden';
    originalHidden.name = 'la';
    originalHidden.value=texte.value;
    formulaire.appendChild(originalHidden);

    // Soumet le formulaire
    formulaire.submit();
}