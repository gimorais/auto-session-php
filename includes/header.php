<header class="header">
    <div class="header__inner container-fluid">
        <button class="header-mobile-toggle d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#headerMobileMenu" aria-controls="headerMobileMenu" aria-expanded="false" aria-label="Abrir menu de navegação">
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>

        <a class="header-logo" href="index.php" aria-label="Ir para a página inicial">
            <img class="header-logo__img" src="assets/img/logo.svg" alt="">
            <span class="header-logo__title">Auto Session</span>
        </a>

        <div class="header-desktop-actions d-none d-lg-flex">
            <nav class="header-nav" aria-label="Navegação principal">
                <div class="header-nav-btn">
                    <a href="index.php" class="header-nav__link header-btn">
                        <i class="bi bi-house-door-fill" aria-hidden="true"></i>
                        Início
                    </a>
                </div>

                <div class="header-nav-btn">
                    <a href="menu.php" class="header-nav__link header-btn">
                        <i class="bi bi-file-text-fill" aria-hidden="true"></i>
                        Menu
                    </a>
                </div>

                <div class="header-nav-btn">
                    <div class="dropdown">
                        <button class="header-nav__link dropdown-toggle header-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-gear-fill" aria-hidden="true"></i>
                            Cadastros
                        </button>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="manterMarca.php">Marcas</a></li>
                            <li><a class="dropdown-item" href="manterModelo.php">Modelos</a></li>
                        </ul>
                    </div>
                </div>

                <div class="header-nav-btn header-nav-btn--clear">
                    <a href="menu.php#limparSessao" class="header-nav__link header-btn">
                        <i class="bi bi-trash3-fill" aria-hidden="true"></i>
                        Limpar Sessão
                    </a>
                </div>
            </nav>

            <label class="switch" title="Alternar entre tema claro e escuro">
                <input type="checkbox" id="theme-toggle-desktop" data-theme-toggle aria-label="Ativar tema escuro">
                <span class="slider"></span>
                <span class="clouds_stars"></span>
            </label>
        </div>

        <span class="header-mobile-spacer d-lg-none" aria-hidden="true"></span>
    </div>

    <div class="collapse header-mobile-menu d-lg-none" id="headerMobileMenu">
        <nav class="header-mobile-nav" aria-label="Navegação para dispositivos móveis">
            <a href="index.php" class="header-mobile-nav__link">
                <i class="bi bi-house-door-fill" aria-hidden="true"></i>
                <span>Início</span>
            </a>

            <a href="menu.php" class="header-mobile-nav__link">
                <i class="bi bi-file-text-fill" aria-hidden="true"></i>
                <span>Menu</span>
            </a>

            <a href="manterMarca.php" class="header-mobile-nav__link">
                <i class="bi bi-bookmark-fill" aria-hidden="true"></i>
                <span>Marcas</span>
            </a>

            <a href="manterModelo.php" class="header-mobile-nav__link">
                <i class="bi bi-car-front-fill" aria-hidden="true"></i>
                <span>Modelos</span>
            </a>

            <a href="menu.php#limparSessao" class="header-mobile-nav__link header-mobile-nav__link--danger">
                <i class="bi bi-trash3-fill" aria-hidden="true"></i>
                <span>Limpar Sessão</span>
            </a>

            <div class="header-mobile-theme">
                <span class="header-mobile-theme__label">
                    <i class="bi bi-moon-stars-fill" aria-hidden="true"></i>
                    Tema escuro
                </span>

                <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="theme-toggle-mobile" data-theme-toggle aria-label="Ativar tema escuro">
                </div>
            </div>
        </nav>
    </div>
</header>
