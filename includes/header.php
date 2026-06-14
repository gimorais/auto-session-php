<header class="header navbar navbar-expand-lg justify-content-between p-3 pe-5 ps-5">
    <div>
        <a class="header-logo d-flex gap-2 align-items-center" href="index.php">
            <img class="header-logo__img" src="assets/img/logo.svg" alt="Logo do sistema">
            <span class="header-logo__title">
                Auto Session
            </span>
        </a>
    </div>
    <div class="d-flex gap-5 align-items-center">
        <nav class="header-nav d-flex gap-4 align-items-center">
            <div class="header-nav-btn">
                <a href="index.php" class="header-nav__link header-btn">
                    <i class="bi bi-house-door-fill"></i>
                    Início
                </a>
            </div>

            <div class="header-nav-btn">
                <a href="menu.php" class="header-nav__link header-btn">
                    <i class="bi bi-file-text-fill"></i>
                    Menu
                </a>
            </div>

            <div class="header-nav-btn">
                <div class="dropdown">
                    <a class="header-nav__link dropdown-toggle header-btn" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-gear-fill"></i>
                        Cadastros
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="manterMarca.php">Marcas</a></li>
                        <li><a class="dropdown-item" href="manterModelo.php">Modelos</a></li>
                    </ul>
                </div>
            </div>

            <div class="header-nav-btn header-nav-btn--clear">
                <a href="menu.php#limparSessao" class="header-nav__link header-btn">
                    <i class="bi bi-trash3-fill"></i>
                    Limpar Sessão
                </a>
            </div>
        </nav>
        
        <label class="switch">
            <input type="checkbox" id="theme-toggle"/>
            <span class="slider"></span>
            <span class="clouds_stars"></span>
        </label>
    </div>
</header>