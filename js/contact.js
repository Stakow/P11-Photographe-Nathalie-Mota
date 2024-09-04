document.addEventListener('DOMContentLoaded', function() {
    const contactLink = document.querySelector('a[href="#"]'); // Lien dans le menu
    const contactButton = document.querySelector('a.contact-button'); 
    const modal = document.querySelector('#contact-modal');
    const closeModal = document.querySelector('#close-modal');

    
    
    // Fonction pour ouvrir la modale
    function openModal(e) {
        e.preventDefault();
        const photoReferenceElement = document.querySelector('#photo-reference');
        const photoReference = photoReferenceElement ? photoReferenceElement.getAttribute('data-reference') : '';

        if (modal) {
            modal.style.display = 'block';
            // Préremplir le champ RÉF. PHOTO
            const photoRefField = document.querySelector('#photo-ref'); 
            if (photoRefField) {
                photoRefField.value = photoReference;
            }
        }
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








