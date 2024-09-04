document.addEventListener('DOMContentLoaded', function() {
    // Sélectionne les boutons de navigation et la miniature
    const prevButton = document.querySelector('.prev-button');
    const nextButton = document.querySelector('.next-button');
    const thumbnailImage = document.getElementById('thumbnail-image');

    // Fonction pour mettre à jour l'image de la miniature
    function updateThumbnail(button) {
        const thumbnailUrl = button.getAttribute('data-thumbnail');
        if (thumbnailUrl) {
            thumbnailImage.src = thumbnailUrl;
            thumbnailImage.style.display = 'block';  // Afficher l'image
        }
    }

    // Réinitialiser la miniature quand le survol cesse
    function resetThumbnail() {
        thumbnailImage.src = '';
        thumbnailImage.style.display = 'none';  // Masquer l'image
    }

    // Gestionnaire d'événement pour le survol des boutons
    if (prevButton) {
        prevButton.addEventListener('mouseover', function() {
            updateThumbnail(prevButton);
        });
        prevButton.addEventListener('mouseout', resetThumbnail);
        prevButton.addEventListener('click', function() {
            window.location.href = prevButton.getAttribute('data-url');
        });
    }

    if (nextButton) {
        nextButton.addEventListener('mouseover', function() {
            updateThumbnail(nextButton);
        });
        nextButton.addEventListener('mouseout', resetThumbnail);
        nextButton.addEventListener('click', function() {
            window.location.href = nextButton.getAttribute('data-url');
        });
    }
});