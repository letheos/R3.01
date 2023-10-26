function process(event) {
    event.preventDefault();

    const phoneNumber = phoneInput.getNumber();

    // Supprimez .submit() et utilisez plutôt .value pour définir la valeur de l'élément "typePhone".
    document.getElementById("typePhone").value = phoneNumber;
}