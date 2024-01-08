function modificationOn(Id) {

    var buttons = document.querySelectorAll('.btn-primary');
    buttons.forEach(function(button) {
        button.style.display = 'none';
    });

    // Show the "Valider" button for the specific element
    var validerButton = document.getElementById('validerButton');
    validerButton.style.display = 'block';

    transformToTextarea(Id);
}

function transformToTextarea(Id) {
    var messageDiv = document.getElementById(Id);
    var validerButton = document.getElementById('validerButton');

    if (messageDiv !== null) {
        console.log(messageDiv.innerText);

        // Check if the existing content is text or an image
        var isText = messageDiv.firstChild instanceof Text;
        var messageContent = isText ? messageDiv.innerText : "";

        var textarea = document.createElement('textarea');
        textarea.name = 'modifiedMessage';
        textarea.value = messageContent;

        // Replace the existing content with the textarea
        messageDiv.removeChild(messageDiv.firstChild);
        messageDiv.appendChild(textarea);

        // Show the "Valider" button

    } else {
        console.error('Element with ID ' + div + ' not found.');
    }
}