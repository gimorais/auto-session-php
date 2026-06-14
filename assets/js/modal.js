document.addEventListener("DOMContentLoaded", function () {
    configurarExclusaoMarca();
    configurarExclusaoModelo();
});

/**
 * Preenche o modal de exclusão de marcas.
 */
function configurarExclusaoMarca() {
    const botoesExcluir = document.querySelectorAll(
        ".btn-excluir-marca"
    );

    const campoId = document.getElementById("idMarcaExcluir");
    const nomeMarca = document.getElementById("nomeMarcaExcluir");

    if (!campoId || !nomeMarca) {
        return;
    }

    botoesExcluir.forEach(function (botao) {
        botao.addEventListener("click", function () {
            const id = botao.dataset.marcaId;
            const descricao = botao.dataset.marcaDescricao;

            campoId.value = id;
            nomeMarca.textContent = `${id} - ${descricao}`;
        });
    });
}

/**
 * Preenche o modal de exclusão de modelos.
 */
function configurarExclusaoModelo() {
    const botoesExcluir = document.querySelectorAll(
        ".btn-excluir-modelo"
    );

    const campoId = document.getElementById("idModeloExcluir");
    const nomeModelo = document.getElementById("nomeModeloExcluir");
    const nomeMarca = document.getElementById("marcaModeloExcluir");

    if (!campoId || !nomeModelo || !nomeMarca) {
        return;
    }

    botoesExcluir.forEach(function (botao) {
        botao.addEventListener("click", function () {
            const id = botao.dataset.modeloId;
            const description = botao.dataset.modeloDescription;
            const marcaDescription = botao.dataset.marcaDescription;

            campoId.value = id;
            nomeModelo.textContent = `${id} - ${description}`;
            nomeMarca.textContent = marcaDescription;
        });
    });
}