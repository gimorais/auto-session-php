<?php
    session_start();

    if (!isset($_SESSION["acessos"])) {
        $_SESSION["acessos"] = 0;
    }

    $accept = $_SERVER["HTTP_ACCEPT"] ?? "";

    if (str_contains($accept, "text/html")) {
        $_SESSION["acessos"]++;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Session</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php require_once __DIR__ . "/includes/header.php"; ?>
    
    <main class="index-main-content container py-5">
        <section class="hero pb-4">
            <h1 class="text-center pb-2">Mini Sistemas de Veículos</h1>
            <p>Este sistema foi desenvolvido para fins educacionais, como atividade prática de PHP, JavaScript, HTML e sessões. O objetivo é simular um cadastro de marcas e modelos de veículos sem utilizar banco de dados.</p>
            <p>Os dados cadastrados são armazenados temporariamente em <strong>$_SESSION</strong>, permanecendo disponíveis durante a navegação do usuário na sessão atual.</p>
        </section>

        <section class="tech" aria-labelledby="tituloTecnologias">
            <div class="tech__heading text-center">
                <span class="tech__tag">Stack do projeto</span>
                <h2 id="tituloTecnologias" class="tech__title">Tecnologias Utilizadas</h2>
                <p class="tech__description">Ferramentas utilizadas para construir a estrutura, a lógica, a interface e o armazenamento temporário do sistema.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col">
                    <article class="tech-card tech-card--php h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true">
                                <i class="bi bi-filetype-php"></i>
                            </div>
                            <span class="tech-card__category">Back-end</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">PHP</h3>
                            <p class="tech-card__text">Responsável pelo processamento dos formulários, gerenciamento de sessões e armazenamento temporário dos dados.</p>
                        </div>
                    </article>
                </div>

                <div class="col">
                    <article class="tech-card tech-card--javascript h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true"><i class="bi bi-filetype-js"></i></div>
                            <span class="tech-card__category">Interatividade</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">JavaScript</h3>
                            <p class="tech-card__text">Utilizado para manipulação do DOM, validação de formulários e implementação de funcionalidades interativas.</p>
                        </div>
                    </article>
                </div>

                <div class="col">
                    <article class="tech-card tech-card--html h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true">
                                <i class="bi bi-filetype-html"></i>
                            </div>
                            <span class="tech-card__category">Estrutura</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">HTML</h3>
                            <p class="tech-card__text">Utilizado para estruturar o conteúdo e criar os formulários de cadastro de marcas e modelos de veículos.</p>
                        </div>
                    </article>
                </div>

                <div class="col">
                    <article class="tech-card tech-card--session h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true">
                                <i class="bi bi-box-arrow-in-right"></i>
                            </div>

                            <span class="tech-card__category">Persistência</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">Sessões</h3>
                            <p class="tech-card__text">Utilizadas para armazenar marcas e modelos durante a navegação do usuário, sem a necessidade de um banco de dados.</p>
                        </div>
                    </article>
                </div>

                <div class="col">
                    <article class="tech-card tech-card--bootstrap h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true">
                                <i class="bi bi-bootstrap-fill"></i>
                            </div>

                            <span class="tech-card__category">Interface</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">Bootstrap</h3>

                            <p class="tech-card__text">Framework utilizado para a estrutura responsiva, organização do layout e criação de componentes da interface.</p>
                        </div>
                    </article>
                </div>

                <div class="col">
                    <article class="tech-card tech-card--scss h-100">
                        <div class="tech-card__top">
                            <div class="tech-card__icon" aria-hidden="true">
                                <i class="bi bi-filetype-scss"></i>
                            </div>

                            <span class="tech-card__category">Estilização</span>
                        </div>

                        <div class="tech-card__content">
                            <h3 class="tech-card__title">SCSS</h3>

                            <p class="tech-card__text">Pré-processador utilizado para organizar os estilos por componentes e permitir variáveis, módulos e aninhamento.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>

    <?php require_once __DIR__ . "/includes/viewcount.php"; ?>
    <?php require_once __DIR__ . "/includes/scroll-top.php"; ?>
    <?php require_once __DIR__ . "/includes/footer.php"; ?>
    <script src="assets/js/theme-toggle.js"></script>
    <script src="assets/js/scroll-top.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>