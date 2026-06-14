document.addEventListener("DOMContentLoaded", function() {
    const themeToggles = document.querySelectorAll("[data-theme-toggle]");
    const body = document.body;

    if (!themeToggles.length) {
        return;
    }

    const savedTheme = localStorage.getItem("theme") || "light";

    function applyTheme(theme) {
        const isDark = theme === "dark";

        body.setAttribute("data-theme", theme);
        localStorage.setItem("theme", theme);

        themeToggles.forEach(function(toggle) {
            toggle.checked = isDark;
            toggle.setAttribute(
                "aria-label",
                isDark ? "Desativar tema escuro" : "Ativar tema escuro"
            );
        });
    }

    applyTheme(savedTheme);

    themeToggles.forEach(function(toggle) {
        toggle.addEventListener("change", function() {
            applyTheme(this.checked ? "dark" : "light");
        });
    });
});
