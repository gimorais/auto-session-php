function validarMarca() {
    const campoId = document.getElementById("id");
    const campoDescription = document.getElementById("description");

    const id = campoId.value.trim();
    const description = campoDescription.value.trim();

    if (id === "") {
        alert("Por favor, preencha o campo ID.");
        campoId.focus();
        return false;
    }

    if (description.length < 3) {
        alert("A descrição deve ter pelo menos 3 caracteres.");
        campoDescription.focus();
        return false;
    }

    return true;
}