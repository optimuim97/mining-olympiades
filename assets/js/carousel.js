document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.querySelector(".carousel");
    const carouselItems = document.querySelectorAll(".carousel-elt");
    let currentIndex = 0;
    let interval;

    function showItem(index) {
        // Réinitialisez l'opacité de tous les éléments
        carouselItems.forEach((item) => {
            item.style.opacity = "0";
        });

        // Affichez l'élément actuel
        carouselItems[index].style.opacity = "1";
    }

    function cycleItems() {
        // Masquez l'élément actuel
        carouselItems[currentIndex].style.opacity = "0";
        currentIndex = (currentIndex + 1) % carouselItems.length;
        // Affichez le nouvel élément actuel
        carouselItems[currentIndex].style.opacity = "1";
    }

    showItem(currentIndex); // Afficher le premier élément

    // Mettez en place l'intervalle pour changer de texte toutes les 3 secondes
    interval = setInterval(cycleItems, 3000);

    // Gérez les événements de survol pour arrêter/reprendre le carousel
    carousel.addEventListener("mouseenter", () => {
        clearInterval(interval); // Arrêter le défilement
    });

    carousel.addEventListener("mouseleave", () => {
        interval = setInterval(cycleItems, 3000); // Reprendre le défilement
    });
});
