document.addEventListener("DOMContentLoaded", function() {
    const themeToggle = document.getElementById("theme-toggle");
    const body = document.body;

    // Verificar se há um tema salvo no localStorage
    const savedTheme = localStorage.getItem("theme");
    if (savedTheme) {
        body.setAttribute("data-theme", savedTheme);
        themeToggle.checked = savedTheme === "dark";
    }

    // Adicionar evento de mudança ao toggle
    themeToggle.addEventListener("change", function() {
        if (this.checked) {
            body.setAttribute("data-theme", "dark");
            localStorage.setItem("theme", "dark");
        } else {
            body.setAttribute("data-theme", "light");
            localStorage.setItem("theme", "light");
        }
    });
});