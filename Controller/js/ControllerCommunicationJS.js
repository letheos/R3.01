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
    var elements = document.querySelectorAll('.buttonSubmit');
    for (var i = 0; i < elements.length; i++) {
        var modifier = elements[i].querySelector("#Modify");
        if (modifier && modifier.style.display === "none") {
            return true;
        }
    }

    return false;
}
function isContentAnImage(Id) {
    var messageDiv = document.getElementById(Id);
    var content = messageDiv.innerHTML.trim();
    var isImage = content.startsWith('<img')
    if (isImage){
        return true;
    }

    return false;
}

function transformToTextarea(Id) {
    var messageDiv = document.getElementById(Id);

    if (messageDiv !== null && !checkIfModifierHidden() && !isContentAnImage(Id)) {
        var originalText = messageDiv.innerText;
        var textarea = document.createElement('textarea');
        textarea.name = 'la';
        textarea.value = originalText;
        textarea.id='letexte';
        var originalHidden = document.createElement('input');
        originalHidden.type = 'hidden';
        originalHidden.name = 'la';
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
    var originalHidden = formulaire.querySelector('input[name="la"]');
    if (originalHidden) {
        originalHidden.value = texte;
    }
    formulaire.submit();
}