document.addEventListener("DOMContentLoaded", function () {
    AOS.init({
        duration: 1000,
        once: true,
        easing: "ease-out-cubic",
    });

    // Particle effect
    function createParticles() {
        const particlesContainer = document.getElementById("particles");
        const numberOfParticles = 50;

        for (let i = 0; i < numberOfParticles; i++) {
            const particle = document.createElement("div");
            particle.className = "particle";

            // Random position
            particle.style.left = Math.random() * 100 + "%";
            particle.style.top = Math.random() * 100 + "%";

            // Random size
            const size = Math.random() * 3;
            particle.style.width = size + "px";
            particle.style.height = size + "px";

            // Random opacity
            particle.style.opacity = Math.random() * 0.5 + 0.2;

            // Animation
            const animationDuration = Math.random() * 3 + 2;
            const animationDelay = Math.random() * 2;
            particle.style.animation = `floating ${animationDuration}s ease-in-out infinite`;
            particle.style.animationDelay = `${animationDelay}s`;

            particlesContainer.appendChild(particle);
        }
    }

    createParticles();

    // Add input focus effects
    const inputGroups = document.querySelectorAll(".input-group");
    inputGroups.forEach((group) => {
        const input = group.querySelector("input");
        const icon = group.querySelector(".input-icon");

        input.addEventListener("focus", () => {
            icon.style.color = "#3b82f6";
            group.style.transform = "translateY(-2px)";
        });

        input.addEventListener("blur", () => {
            icon.style.color = "rgba(255, 255, 255, 0.4)";
            group.style.transform = "translateY(0)";
        });
    });

    // Initialize theme from localStorage
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.setAttribute("data-theme", savedTheme);
    document.body.classList.remove("light", "dark");
    document.body.classList.add(savedTheme);

    // Listen for theme changes
    window.addEventListener("themeChanged", function (e) {
        const newTheme = e.detail;
        document.documentElement.setAttribute("data-theme", newTheme);
        document.body.classList.remove("light", "dark");
        document.body.classList.add(newTheme);
    });
});
