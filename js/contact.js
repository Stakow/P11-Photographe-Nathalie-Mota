document.addEventListener('DOMContentLoaded', function() {
    const contactLink = document.querySelector('a[href="#"]'); // Lien dans le menu
    const contactButton = document.querySelector('a.contact-button'); // Bouton contact sur la page single.php
    const modal = document.querySelector('#contact-modal');
    const closeModal = document.querySelector('#close-modal');

    // Fonction pour ouvrir la modale
    function openModal(e) {
        e.preventDefault();
        modal.style.display = 'block';
    }

    // Ouvrir la modale via le lien du menu
    if (contactLink && modal) {
        contactLink.addEventListener('click', openModal);
    }

    // Ouvrir la modale via le bouton contact sur la page single.php
    if (contactButton && modal) {
        contactButton.addEventListener('click', openModal);
    }

    // Fermer la modale via le bouton de fermeture
    if (closeModal && modal) {
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    // Fermer la modale en cliquant en dehors de celle-ci
    if (modal) {
        window.addEventListener('click', function(e) {
            if (e.target == modal) {
                modal.style.display = 'none';
            }
        });
    }
});








