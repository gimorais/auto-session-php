<?php
    session_start();

    if (!isset($_SESSION["marcas"])) {
        $_SESSION["marcas"] = [];
    }

    if (!isset($_SESSION["modelos"])) {
        $_SESSION["modelos"] = [];
    }

    $mensagemErro = "";

    $status = $_GET["status"] ?? "";

    $mensagensStatus = [
        "cadastrado" => "Modelo cadastrado com sucesso.",
        "alterado" => "Modelo alterado com sucesso.",
        "excluido" => "Modelo excluído com sucesso."
    ];

    $modo = "cadastrar";
    $idOriginal = "";

    $id = "";
    $description = "";
    $idmarca = "";

    /**
     * Retorna a descrição da marca correspondente ao ID.
     */
    function buscarDescricaoMarca($idmarca): string
    {
        foreach ($_SESSION["marcas"] as $marca) {
            if ((string) $marca["id"] === (string) $idmarca) {
                return $marca["description"];
            }
        }

        return "Marca não encontrada";
    }

    /**
     * Verifica se já existe um modelo com o ID informado.
     */
    function modeloIdExiste($id): bool
    {
        foreach ($_SESSION["modelos"] as $modelo) {
            if ((string) $modelo["id"] === (string) $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Verifica se a marca selecionada existe.
     */
    function marcaExistePorId($idmarca): bool
    {
        foreach ($_SESSION["marcas"] as $marca) {
            if ((string) $marca["id"] === (string) $idmarca) {
                return true;
            }
        }

        return false;
    }

    /**
     * Procura a posição de um modelo dentro do array da sessão.
     */
    function buscarIndiceModeloPorId($id): ?int
    {
        foreach ($_SESSION["modelos"] as $indice => $modelo) {
            if ((string) $modelo["id"] === (string) $id) {
                return $indice;
            }
        }

        return null;
    }

    /*
    * CARREGAR MODELO PARA EDIÇÃO
    */
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["editar"])) {
        $idEditar = trim($_GET["editar"]);

        $indiceModelo = buscarIndiceModeloPorId($idEditar);

        if ($indiceModelo === null) {
            $mensagemErro = "O modelo selecionado não foi encontrado.";
        } else {
            $modeloEditar = $_SESSION["modelos"][$indiceModelo];

            $modo = "editar";
            $idOriginal = $modeloEditar["id"];

            $id = $modeloEditar["id"];
            $description = $modeloEditar["description"];
            $idmarca = $modeloEditar["idmarca"];
        }
    }

    /*
    * PROCESSAMENTO DOS FORMULÁRIOS
    */
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $acao = $_POST["acao"] ?? "";

        /*
        * CADASTRO OU EDIÇÃO DO MODELO
        */
        if ($acao === "salvar") {
            $modo = $_POST["modo"] ?? "cadastrar";
            $idOriginal = trim($_POST["id_original"] ?? "");

            $id = trim($_POST["id"] ?? "");
            $description = trim($_POST["description"] ?? "");
            $idmarca = trim($_POST["idmarca"] ?? "");

            /*
            * Durante a edição, o ID original é mantido.
            */
            if ($modo === "editar") {
                $id = $idOriginal;
            }

            if (empty($_SESSION["marcas"])) {
                $mensagemErro = "Cadastre uma marca antes de cadastrar modelos.";
            } elseif ($id === "") {
                $mensagemErro = "Preencha o campo ID do modelo.";
            } elseif ($description === "") {
                $mensagemErro = "Preencha o nome do modelo.";
            } elseif ($idmarca === "") {
                $mensagemErro = "Selecione uma marca.";
            } elseif (!marcaExistePorId($idmarca)) {
                $mensagemErro = "A marca selecionada não existe.";
            } elseif (
                $modo === "cadastrar" && modeloIdExiste($id)
            ) {
                $mensagemErro = "Já existe um modelo cadastrado com esse ID.";
            } elseif ($modo === "editar") {
                $indiceModelo = buscarIndiceModeloPorId($idOriginal);

                if ($indiceModelo === null) {
                    $mensagemErro = "O modelo que seria alterado não foi encontrado.";
                } else {
                    $_SESSION["modelos"][$indiceModelo] = [
                        "id" => $idOriginal,
                        "description" => $description,
                        "idmarca" => $idmarca
                    ];

                    header("Location: manterModelo.php?status=alterado");
                    exit;
                }
            } else {
                $_SESSION["modelos"][] = [
                    "id" => $id,
                    "description" => $description,
                    "idmarca" => $idmarca
                ];

                header("Location: manterModelo.php?status=cadastrado");
                exit;
            }
        }

        /*
        * EXCLUSÃO DO MODELO
        */
        elseif ($acao === "excluir") {
            $idExcluir = trim($_POST["id_excluir"] ?? "");

            if ($idExcluir === "") {
                $mensagemErro =
                    "Não foi possível identificar o modelo.";
            } elseif (!modeloIdExiste($idExcluir)) {
                $mensagemErro =
                    "O modelo informado não foi encontrado.";
            } else {
                $_SESSION["modelos"] = array_values(
                    array_filter($_SESSION["modelos"],
                        function ($modelo) use ($idExcluir) {
                            return
                                (string) $modelo["id"] !==
                                (string) $idExcluir;
                        }
                    )
                );

                header("Location: manterModelo.php?status=excluido");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manter Modelo</title>
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
        <section class="manter-modelo-section">
            <h1 class="text-center mb-4">
                <?= $modo === "editar"
                    ? "Editar Modelo"
                    : "Cadastro de Modelos"
                ?>
            </h1>

            <?php if (empty($_SESSION["marcas"])): ?>
                <div class="alert app-alert app-alert--warning" role="alert">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Cadastro de marca necessário
                        </span>

                        <span class="app-alert__message">
                            Cadastre pelo menos uma marca antes de cadastrar modelos.
                        </span>

                        <div class="mt-2">
                            <a href="manterMarca.php" class="btn btn-warning">
                                <i class="bi bi-folder-plus"></i>
                                Cadastrar marca
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <form class="modelo-form card mx-auto" action="manterModelo.php" method="post" onsubmit="return validarModelo()">
                    <input type="hidden" name="acao" value="salvar">
                    <input type="hidden" name="modo" value="<?= htmlspecialchars($modo) ?>">
                    <input type="hidden" name="id_original" value="<?= htmlspecialchars($idOriginal) ?>">

                    <div class="form-group p-4">
                        <div class="row text-center g-3">
                            <div class="col-12 col-lg-4">
                                <label for="idmarca" class="form-label fw-bold">
                                    Marca
                                </label>

                                <select name="idmarca" id="idmarca" class="form-select" required>
                                    <option value="" disabled hidden <?= $idmarca === "" ? "selected" : "" ?>>
                                        Selecione uma marca
                                    </option>

                                    <?php foreach ($_SESSION["marcas"] as $marca): ?>
                                        <option value="<?= htmlspecialchars($marca["id"]) ?>" <?=(string) $idmarca === (string) $marca["id"] ? "selected" : "" ?>>
                                            <?= htmlspecialchars($marca["id"]) ?> - <?= htmlspecialchars($marca["description"]) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="id" class="form-label fw-bold">ID do Modelo</label>
                                <input type="number" class="form-control" id="id" name="id" value="<?= htmlspecialchars($id) ?>" <?= $modo === "editar" ? "readonly" : "" ?> required>
                            </div>

                            <div class="col-12 col-lg-4">
                                <label for="description" class="form-label fw-bold">Nome do Modelo</label>
                                <input type="text" class="form-control" id="description" name="description" value="<?= htmlspecialchars($description) ?>" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-floppy-fill"></i>
                                <?= $modo === "editar"
                                    ? "Salvar alterações"
                                    : "Cadastrar"
                                ?>
                            </button>

                            <?php if ($modo === "editar"): ?>
                                <a href="manterModelo.php" class="btn btn-secondary">
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
            <?php endif; ?>

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

        <section aria-labelledby="tituloModelosCadastrados">
            <h2 id="tituloModelosCadastrados" class="text-center mb-4 mt-5">
                Modelos Cadastrados
            </h2>

            <?php if (empty($_SESSION["modelos"])): ?>
                <div class="alert app-alert app-alert--info" role="status">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Nenhum modelo cadastrado
                        </span>

                        <span class="app-alert__message">
                            Os modelos cadastrados aparecerão nesta área.
                        </span>
                    </div>
                </div>
            <?php else: ?>
                <div class="model-filter mx-auto mb-4">
                    <label for="filtroMarca" class="model-filter__label">
                        Filtrar modelos por marca
                    </label>

                    <div class="filter-select">
                        <i class="bi bi-funnel filter-select__icon"></i>

                        <select id="filtroMarca" class="filter-select__field">
                            <option value="">
                                Todas as marcas
                            </option>

                            <?php foreach ($_SESSION["marcas"] as $marca): ?>
                                <option value="<?= htmlspecialchars($marca["id"]) ?>">
                                    <?= htmlspecialchars($marca["id"]) ?>
                                    -
                                    <?= htmlspecialchars($marca["description"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <i class="bi bi-chevron-down filter-select__arrow"></i>
                    </div>
                </div>

                <div class="table-responsive data-table-wrapper">
                    <table id="tabelaModelos" class="table table-striped table-hover data-table align-middle">
                        <thead>
                            <tr>
                                <th>ID Marca</th>
                                <th>Nome Marca</th>
                                <th>ID Modelo</th>
                                <th>Nome Modelo</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($_SESSION["modelos"] as $modelo): ?>
                                <tr class="modelo-row" data-idmarca="<?= htmlspecialchars($modelo["idmarca"]) ?>">
                                    <td><?= htmlspecialchars($modelo["idmarca"]) ?></td>
                                    <td><?= htmlspecialchars(buscarDescricaoMarca($modelo["idmarca"])) ?></td>
                                    <td><?= htmlspecialchars($modelo["id"]) ?></td>
                                    <td><?= htmlspecialchars($modelo["description"]) ?></td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="manterModelo.php?editar=<?= urlencode($modelo["id"]) ?>" class="btn btn-sm btn-warning" aria-label="Editar modelo <?= htmlspecialchars($modelo["description"]) ?>" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <button type="button" class="btn btn-sm btn-danger btn-excluir-modelo" data-bs-toggle="modal" data-bs-target="#modalExcluirModelo" data-modelo-id="<?= htmlspecialchars($modelo["id"], ENT_QUOTES, "UTF-8") ?>" data-modelo-description="<?= htmlspecialchars($modelo["description"], ENT_QUOTES, "UTF-8") ?>" data-marca-description="<?= htmlspecialchars(buscarDescricaoMarca($modelo["idmarca"]), ENT_QUOTES, "UTF-8") ?>" aria-label="Excluir modelo <?= htmlspecialchars($modelo["description"], ENT_QUOTES, "UTF-8") ?>" title="Excluir">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="mensagemNenhumModelo" class="alert app-alert app-alert--warning d-none mt-3" role="status" aria-live="polite">
                    <div class="app-alert__icon" aria-hidden="true">
                        <i class="bi bi-search"></i>
                    </div>

                    <div class="app-alert__content">
                        <span class="app-alert__title">
                            Nenhum resultado
                        </span>

                        <span class="app-alert__message">
                            Nenhum modelo foi encontrado para a marca selecionada.
                        </span>
                    </div>
                </div>

                <div class="modal fade delete-modal" id="modalExcluirModelo" tabindex="-1" aria-labelledby="tituloModalExcluirModelo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <div>
                                    <span class="delete-modal__tag">Confirmação necessária</span>

                                    <h2 class="modal-title" id="tituloModalExcluirModelo">Excluir modelo?</h2>
                                </div>

                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                            </div>

                            <div class="modal-body">
                                <div class="delete-modal__warning">
                                    <div class="delete-modal__icon" aria-hidden="true">
                                        <i class="bi bi-trash3-fill"></i>
                                    </div>

                                    <div>
                                        <p class="mb-1">Você está prestes a excluir o modelo:</p>

                                        <strong id="nomeModeloExcluir"></strong>

                                        <p class="delete-modal__brand mb-0 mt-1">
                                            Marca: <span id="marcaModeloExcluir"></span>
                                        </p>
                                    </div>
                                </div>

                                <p class="delete-modal__message mb-0">
                                    Essa operação não poderá ser desfeita.
                                </p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancelar
                                </button>

                                <form action="manterModelo.php" method="post">
                                    <input type="hidden" name="acao" value="excluir">
                                    <input type="hidden" name="id_excluir" id="idModeloExcluir">

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
    <script src="assets/js/filters.js"></script>
    <script src="assets/js/modal.js"></script>
    <script src="assets/js/scroll-top.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>