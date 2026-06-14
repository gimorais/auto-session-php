document.addEventListener("DOMContentLoaded", function () {
    const filtroMarca = document.getElementById("filtroMarca");

    const linhasModelos = document.querySelectorAll(
        ".modelo-row"
    );

    const mensagemNenhumModelo = document.getElementById(
        "mensagemNenhumModelo"
    );

    if (!filtroMarca) {
        return;
    }

    filtroMarca.addEventListener("change", function () {
        const idMarcaSelecionada = filtroMarca.value;

        let quantidadeVisivel = 0;

        linhasModelos.forEach(function (linha) {
            const idMarcaModelo = linha.dataset.idmarca;

            const mostrarLinha =
                idMarcaSelecionada === "" ||
                idMarcaModelo === idMarcaSelecionada;

            linha.classList.toggle(
                "d-none",
                !mostrarLinha
            );

            if (mostrarLinha) {
                quantidadeVisivel++;
            }
        });

        if (mensagemNenhumModelo) {
            mensagemNenhumModelo.classList.toggle(
                "d-none",
                quantidadeVisivel > 0
            );
        }
    });
});
