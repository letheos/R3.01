function transformToTextarea(Id) {
    var messageDiv = document.getElementById(Id);

    if (messageDiv !== null) {
        console.log(messageDiv.innerText)
        var messageContent = messageDiv.innerText;

        var textarea = document.createElement('textarea');
        textarea.name = 'modifiedMessage';
        textarea.value = messageContent.innerText;

        // Remplacer le contenu existant par le textarea
        messageDiv.removeChild(messageDiv.firstChild)
        messageDiv.appendChild(textarea);
    } else {
        console.error('Element with ID ' + div + ' not found.');
    }
}