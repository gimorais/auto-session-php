<?php
    session_start();

    if (!isset($_SESSION["marcas"])) {
        $_SESSION["marcas"] = [];
    }

    if (!isset($_SESSION["modelos"])) {
        $_SESSION["modelos"] = [];
    }

    $mensagemErro = "";

    $modo = "cadastrar";
    $idOriginal = "";

    $id = "";
    $description = "";

    /**
     * Verifica se já existe uma marca com o ID informado.
     */
    function marcaIdExiste($id): bool
    {
        foreach ($_SESSION["marcas"] as $marca) {
            if ((string) $marca["id"] === (string) $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se já existe uma marca com a descrição informada.
     * Durante a edição, ignora a própria marca.
     */
    function marcaDescriptionExiste($description, $idIgnorar = null ): bool {
        foreach ($_SESSION["marcas"] as $marca) {
            $mesmaDescricao =
                strtolower(trim($marca["description"])) ===
                strtolower(trim($description));

            $registroDiferente =
                $idIgnorar === null ||
                (string) $marca["id"] !== (string) $idIgnorar;

            if ($mesmaDescricao && $registroDiferente) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se a marca possui algum modelo vinculado.
     */
    function marcaPossuiModelos($idmarca): bool {
        foreach ($_SESSION["modelos"] as $modelo) {
            if ((string) $modelo["idmarca"] === (string) $idmarca) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retorna o índice da marca dentro do array da sessão.
     */
    function buscarIndiceMarcaPorId($id): ? int {
        foreach ($_SESSION["marcas"] as $indice => $marca) {
            if ((string) $marca["id"] === (string) $id) {
                return $indice;
            }
        }

        return null;
    }

    /*
    * CARREGAR MARCA PARA EDIÇÃO
    */
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["editar"])) {
        $idEditar = trim($_GET["editar"]);

        $indiceMarca = buscarIndiceMarcaPorId($idEditar);

        if ($indiceMarca === null) {
            $mensagemErro = "A marca selecionada não foi encontrada.";
        } else {
            $marcaEditar = $_SESSION["marcas"][$indiceMarca];

            $modo = "editar";
            $idOriginal = $marcaEditar["id"];

            $id = $marcaEditar["id"];
            $description = $marcaEditar["description"];
        }
    }

    /*
    * PROCESSAMENTO DOS FORMULÁRIOS
    */
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $acao = $_POST["acao"] ?? "";

        /*
        * CADASTRAR OU EDITAR MARCA
        */
        if ($acao === "salvar") {
            $modo = $_POST["modo"] ?? "cadastrar";
            $idOriginal = trim($_POST["id_original"] ?? "");

            $id = trim($_POST["id"] ?? "");
            $description = trim($_POST["description"] ?? "");

            /*
            * Durante a edição, o ID original é mantido.
            * Isso evita quebrar os modelos vinculados.
            */
            if ($modo === "editar") {
                $id = $idOriginal;
            }

            if ($id === "") {
                $mensagemErro = "Preencha o campo ID.";
            } elseif (strlen($description) < 3) {
                $mensagemErro =
                    "A descrição deve ter pelo menos 3 caracteres.";
            } elseif (
                $modo === "cadastrar" &&
                marcaIdExiste($id)
            ) {
                $mensagemErro =
                    "Já existe uma marca cadastrada com esse ID.";
            } elseif (
                marcaDescriptionExiste(
                    $description,
                    $modo === "editar" ? $idOriginal : null
                )
            ) {
                $mensagemErro =
                    "Já existe uma marca cadastrada com esse nome.";
            } elseif ($modo === "editar") {
                $indiceMarca = buscarIndiceMarcaPorId($idOriginal);

                if ($indiceMarca === null) {
                    $mensagemErro =
                        "A marca que seria alterada não foi encontrada.";
                } else {
                    $_SESSION["marcas"][$indiceMarca] = [
                        "id" => $idOriginal,
                        "description" => $description
                    ];

                    header("Location: manterMarca.php?status=alterada");
                    exit;
                }
            } else {
                $_SESSION["marcas"][] = [
                    "id" => $id,
                    "description" => $description
                ];

                header("Location: manterMarca.php?status=cadastrada");
                exit;
            }
        }

        /*
        * EXCLUSÃO DE MARCA
        */
        elseif ($acao === "excluir") {
            $idExcluir = trim($_POST["id_excluir"] ?? "");

            if ($idExcluir === "") {
                $mensagemErro =
                    "Não foi possível identificar a marca.";
            } elseif (marcaPossuiModelos($idExcluir)) {
                $mensagemErro =
                    "Essa marca não pode ser excluída porque possui modelos vinculados.";
            } elseif (!marcaIdExiste($idExcluir)) {
                $mensagemErro =
                    "A marca informada não foi encontrada.";
            } else {
                $_SESSION["marcas"] = array_values(
                    array_filter(
                        $_SESSION["marcas"],
                        function ($marca) use ($idExcluir) {
                            return
                                (string) $marca["id"] !==
                                (string) $idExcluir;
                        }
                    )
                );

                header(
                    "Location: manterMarca.php?status=excluida"
                );
                exit;
            }
        }
    }

    /*
    * FILTRO DE MARCAS POR DESCRIÇÃO COM PHP
    */
    $busca = trim($_GET["busca"] ?? "");

    $marcasFiltradas = $_SESSION["marcas"];

    if ($busca !== "") {
        $marcasFiltradas = array_filter(
            $_SESSION["marcas"],
            function ($marca) use ($busca) {
                return stripos(
                    $marca["description"],
                    $busca
                ) !== false;
            }
        );
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manter Marca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>

    <main class="maintenance-main container w-50 py-5">
        <section class="marca-form-section">
            <h1 class="text-center mb-4">
                <?= $modo === "editar"
                    ? "Editar Marca"
                    : "Cadastro de Marcas"
                ?>
            </h1>

            <form class="marca-form card mx-auto" action="manterMarca.php" method="post" onsubmit="return validarMarca()">
                <input type="hidden" name="acao" value="salvar" >
                <input type="hidden" name="modo" value="<?= htmlspecialchars($modo) ?>">
                <input type="hidden" name="id_original" value="<?= htmlspecialchars($idOriginal) ?>">

                <div class="form-group p-4">
                    <div class="row text-center g-3">
                        <div class="col-12 col-md-6">
                            <label for="id" class="form-label fw-bold">
                                ID da Marca
                            </label>
                            <input type="number" class="form-control" id="id" name="id" value="<?= htmlspecialchars($id) ?>" <?= $modo === "editar" ? "readonly" : "" ?> required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="description" class="form-label fw-bold">
                                Nome da Marca
                            </label>

                            <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($description) ?>" minlength="3" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy-fill"></i>
                            <?= $modo === "editar" ? "Salvar alterações" : "Cadastrar" ?>
                        </button>

                        <?php if ($modo === "editar"): ?>
                            <a href="manterMarca.php" class="btn btn-secondary" >
                                <i class="bi bi-x-circle"></i>
                                Cancelar edição
                            </a>
                        <?php else: ?>
                            <button type="reset" class="btn btn-warning">
                                <i class="bi bi-arrow-repeat"></i>
                                Limpar
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <?php if ($mensagemErro !== ""): ?>
                <div class="alert app-alert app-alert--danger alert-dismissible fade show mt-3" role="alert">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Não foi possível concluir
                        </span>

                        <span class="app-alert__message">
                            <?= htmlspecialchars($mensagemErro) ?>
                        </span>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>

            <?php
                $status = $_GET["status"] ?? "";

                $mensagensStatus = [
                    "cadastrada" => "Marca cadastrada com sucesso.",
                    "alterada" => "Marca alterada com sucesso.",
                    "excluida" => "Marca excluída com sucesso."
                ];
            ?>

            <?php if (isset($mensagensStatus[$status])): ?>
                <div class="alert app-alert app-alert--success alert-dismissible fade show mt-3" role="alert">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Operação concluída
                        </span>

                        <span class="app-alert__message">
                            <?= htmlspecialchars($mensagensStatus[$status]) ?>
                        </span>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                </div>
            <?php endif; ?>
        </section>

        <section aria-labelledby="tituloMarcasCadastradas">
            <h2 id="tituloMarcasCadastradas" class="text-center mb-4 mt-5">
                Marcas Cadastradas
            </h2>

            <?php if (!empty($_SESSION["marcas"])): ?>
                <form action="manterMarca.php" method="get" class="search-bar mx-auto mb-4" role="search">
                    <i class="bi bi-search search-bar__icon"></i>
                    <input type="search" class="search-bar__input" id="busca" name="busca" placeholder="Buscar marca pela descrição..." value="<?= htmlspecialchars($_GET["busca"] ?? "") ?>" aria-label="Buscar marca">

                    <button type="submit" class="search-bar__button" aria-label="Pesquisar">
                        Buscar
                    </button>
                </form>
            <?php endif; ?>

            <?php if (empty($_SESSION["marcas"])): ?>
                <div class="alert app-alert app-alert--info" role="status">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Nenhum cadastro
                        </span>

                        <span class="app-alert__message">
                            Nenhuma marca foi cadastrada ainda.
                        </span>
                    </div>
                </div>

            <?php elseif (empty($marcasFiltradas)): ?>
                <div class="alert app-alert app-alert--warning" role="status">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-search"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Nenhum resultado
                        </span>

                        <span class="app-alert__message">
                            Nenhuma marca foi encontrada para a busca
                            <strong>“<?= htmlspecialchars($busca) ?>”</strong>
                        </span>
                    </div>
                </div>

            <?php else: ?>
                <div class="table-responsive data-table-wrapper">
                    <table class="table table-striped table-hover data-table align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($marcasFiltradas as $marca): ?>
                                <tr>
                                    <td><?= htmlspecialchars($marca["id"]) ?></td>
                                    <td><?= htmlspecialchars($marca["description"]) ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="manterMarca.php?editar=<?= urlencode($marca["id"]) ?>" class="btn btn-sm btn-warning" aria-label="Editar marca <?= htmlspecialchars($marca["description"]) ?>" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger btn-excluir-marca" data-bs-toggle="modal" data-bs-target="#modalExcluirMarca"data-marca-id=" <?= htmlspecialchars($marca["id"], ENT_QUOTES, "UTF-8") ?>" data-marca-descricao="<?= htmlspecialchars($marca["description"], ENT_QUOTES, "UTF-8") ?>" aria-label="Excluir marca <?= htmlspecialchars($marca["description"]) ?>" title="Excluir">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade delete-modal" id="modalExcluirMarca" tabindex="-1" aria-labelledby="tituloModalExcluirMarca" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <span class="delete-modal__tag">
                                        Confirmação necessária
                                    </span>
        
                                    <h2 class="modal-title" id="tituloModalExcluirMarca">Excluir marca?</h2>
                                </div>
        
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>
        
                            <div class="modal-body">
                                <div class="delete-modal__warning">
                                    <div class="delete-modal__icon">
                                        <i class="bi bi-trash3-fill"></i>
                                    </div>
        
                                    <div>
                                        <p class="mb-1"> Você está prestes a excluir a marca: </p>
                                        <strong id="nomeMarcaExcluir"></strong>
                                    </div>
                                </div>
        
                                <p class="delete-modal__message mb-0">Essa operação não poderá ser desfeita.</p>
                            </div>
        
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
        
                                <form action="manterMarca.php" method="post">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id_excluir" id="idMarcaExcluir">
        
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash3-fill"></i>
                                        Confirmar exclusão
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <?php require_once __DIR__ . "/includes/scroll-top.php"; ?>
    <?php require_once __DIR__ . "/includes/footer.php"; ?>

    <script src="assets/js/theme-toggle.js"></script>
    <script src="assets/js/validation.js"></script>
    <script src="assets/js/modal.js"></script>
    <script src="assets/js/scroll-top.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>