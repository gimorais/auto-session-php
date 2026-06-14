document.addEventListener("DOMContentLoaded", function () {
    const scrollTopButton = document.getElementById("scrollTopButton");

    if (!scrollTopButton) {
        return;
    }

    const distanciaParaMostrar = 300;

    function atualizarVisibilidade() {
        const paginaTemRolagem =
            document.documentElement.scrollHeight >
            window.innerHeight + 10;

        const usuarioDesceu =
            window.scrollY > distanciaParaMostrar;

        const deveMostrar =
            paginaTemRolagem && usuarioDesceu;

        scrollTopButton.classList.toggle(
            "is-visible",
            deveMostrar
        );

        scrollTopButton.tabIndex = deveMostrar ? 0 : -1;
        scrollTopButton.setAttribute(
            "aria-hidden",
            String(!deveMostrar)
        );
    }

    scrollTopButton.addEventListener("click", function () {
        const reduzirMovimento = window.matchMedia(
            "(prefers-reduced-motion: reduce)"
        ).matches;

        window.scrollTo({
            top: 0,
            behavior: reduzirMovimento ? "auto" : "smooth"
        });
    });

    window.addEventListener(
        "scroll",
        atualizarVisibilidade,
        { passive: true }
    );

    window.addEventListener(
        "resize",
        atualizarVisibilidade
    );

    atualizarVisibilidade();
});