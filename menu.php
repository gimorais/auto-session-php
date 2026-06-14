<?php
    session_start();

    $quantidadeMarcas = count($_SESSION["marcas"] ?? []);
    $quantidadeModelos = count($_SESSION["modelos"] ?? []);

    $possuiDados = $quantidadeMarcas > 0 || $quantidadeModelos > 0;
    $mensagem = $_GET["msg"] ?? "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>

    <main class="menu-main-content container mx-auto py-5">
        <section class="menu-cadastros" aria-labelledby="tituloCadastros">
            <div class="mb-4">
                <span class="menu-cadastros__tag">
                    Painel de controle
                </span>

                <h1 id="tituloCadastros" class="menu-cadastros__titulo mt-2 mb-1">
                    Gerencie seus veículos
                </h1>

                <p class="menu-cadastros__descricao mb-0">
                    Acesse os cadastros de marcas e modelos do sistema.
                </p>
            </div>

            <div class="row g-4">
                <!-- Card de marcas -->
                <div class="col-12 col-xl-6">
                    <article class="menu-card menu-card--marcas h-100">
                        <div class="menu-card__media">
                            <img class="menu-card__imagem" src="assets/img/marcas.svg" alt="Ilustração de um carro roxo representando marcas">

                            <span class="menu-card__categoria">
                                <i class="bi bi-nut-fill"></i>
                                Marcas
                            </span>
                        </div>

                        <div class="menu-card__conteudo">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <h2 class="menu-card__titulo">
                                        Marcas cadastradas
                                    </h2>

                                    <p class="menu-card__texto">
                                        Cadastre, edite, pesquise e exclua marcas de veículos.
                                    </p>
                                </div>

                                <div class="menu-card__contador" aria-label="Quantidade de marcas cadastradas">
                                    <?= $quantidadeMarcas ?>
                                </div>
                            </div>

                            <a class="btn menu-card__botao w-100 mt-auto" href="manterMarca.php">
                                Gerenciar marcas
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Card de modelos -->
                <div class="col-12 col-xl-6">
                    <article class="menu-card menu-card--modelos h-100">
                        <div class="menu-card__media">
                            <img class="menu-card__imagem" src="assets/img/modelos.svg" alt="Ilustração de vários carros roxos representando modelos">

                            <span class="menu-card__categoria">
                                <i class="bi bi-car-front-fill"></i>
                                Modelos
                            </span>
                        </div>

                        <div class="menu-card__conteudo">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <h2 class="menu-card__titulo">
                                        Modelos cadastrados
                                    </h2>

                                    <p class="menu-card__texto">
                                        Organize os modelos e relacione cada um à sua marca.
                                    </p>
                                </div>

                                <div class="menu-card__contador" aria-label="Quantidade de modelos cadastrados">
                                    <?= $quantidadeModelos ?>
                                </div>
                            </div>

                            <a
                                class="btn menu-card__botao w-100 mt-auto"
                                href="manterModelo.php"
                            >
                                Gerenciar modelos
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <?php if ($mensagem === "sessao_limpa"): ?>
            <div class="session-feedback alert alert-success alert-dismissible fade show mt-4" role="alert">
                <i class="bi bi-check-circle-fill"></i>

                <span>
                    Os dados de marcas e modelos foram apagados com sucesso.
                </span>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        <?php endif; ?>

        <section id="limparSessao" class="menu-clear" aria-labelledby="tituloLimparSessao">
            <div class="menu-clear__icon" aria-hidden="true">
                <i class="bi bi-trash3-fill"></i>
            </div>

            <div class="menu-clear__content">
                <span class="menu-clear__tag">
                    Zona de perigo
                </span>

                <h2 id="tituloLimparSessao" class="menu-clear__title">
                    Limpar dados da sessão
                </h2>

                <p class="menu-clear__description">
                    Essa ação remove todas as marcas e todos os modelos cadastrados durante a sessão atual. Os dados apagados não poderão ser recuperados.
                </p>

                <div class="menu-clear__stats">
                    <span class="menu-clear__stat">
                        <i class="bi bi-nut-fill"></i>

                        <strong><?= $quantidadeMarcas ?></strong>

                        <?= $quantidadeMarcas === 1 ? "marca" : "marcas" ?>
                    </span>

                    <span class="menu-clear__stat">
                        <i class="bi bi-car-front-fill"></i>

                        <strong><?= $quantidadeModelos ?></strong>

                        <?= $quantidadeModelos === 1 ? "modelo" : "modelos" ?>
                    </span>
                </div>
            </div>

            <div class="menu-clear__action">
                <button type="button" class="menu-clear__button"
                    <?php if ($possuiDados): ?>
                        data-bs-toggle="modal"
                        data-bs-target="#modalLimparSessao"
                    <?php else: ?>
                        disabled
                    <?php endif; ?>
                >
                    <i class="bi bi-trash3"></i>

                    <?= $possuiDados
                        ? "Limpar dados"
                        : "Nenhum dado para limpar"
                    ?>
                </button>
            </div>
        </section>

        <?php if ($possuiDados): ?>
            <div class="modal fade session-clear-modal" id="modalLimparSessao" tabindex="-1" aria-labelledby="tituloModalLimparSessao" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span class="session-clear-modal__tag">
                                    Confirmação necessária
                                </span>

                                <h2 class="modal-title" id="tituloModalLimparSessao">
                                    Limpar a sessão?
                                </h2>
                            </div>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>

                        <div class="modal-body">
                            <div class="session-clear-modal__warning">
                                <i class="bi bi-exclamation-triangle-fill"></i>

                                <p>
                                    Você está prestes a apagar <strong><?= $quantidadeMarcas ?> <?= $quantidadeMarcas === 1 ? "marca" : "marcas" ?></strong> e <strong><?= $quantidadeModelos ?> <?= $quantidadeModelos === 1 ? "modelo" : "modelos" ?></strong>.
                                </p>
                            </div>

                            <p class="mb-0">Essa operação não poderá ser desfeita.</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancelar
                            </button>

                            <form action="limparSessao.php" method="post">
                                <button type="submit" name="confirmarLimpeza" value="1" class="btn btn-danger">
                                    <i class="bi bi-trash3-fill"></i>
                                    Confirmar limpeza
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php require_once __DIR__ . "/includes/scroll-top.php"; ?>
    <?php require_once __DIR__ . "/includes/footer.php"; ?>

    <script src="assets/js/theme-toggle.js"></script>
    <script src="assets/js/scroll-top.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>