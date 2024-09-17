function initLightbox() {
    const lightbox = document.getElementById('photo-lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxTitle = document.getElementById('reference-photo');
    const lightboxCat = document.getElementById('categorie-photo');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    let currentPhotoIndex = -1;
    let photos = [];

    if (!lightbox || !lightboxImg || !lightboxTitle || !lightboxCat) {
        console.error('Un ou plusieurs éléments de la lightbox sont introuvables.');
        return;
    }

    // Ouvrir la lightbox
    document.querySelectorAll('.open-lightbox').forEach((element, index) => {
        element.addEventListener('click', function () {
            const imgSrc = this.getAttribute('data-img');
            const title = this.getAttribute('data-title');
            const cat = this.getAttribute('data-cat');
            currentPhotoIndex = index;
            photos = document.querySelectorAll('.open-lightbox');

            lightboxImg.src = imgSrc;
            lightboxTitle.textContent = title;
            lightboxCat.textContent = cat;
            lightbox.style.display = 'block';

            // Cacher les icônes .open-lightbox
            document.querySelectorAll('.open-lightbox').forEach(icon => {
                icon.style.display = 'none';
            });
        });
    });

    // Fermer la lightbox
    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            lightbox.style.display = 'none';

            document.querySelectorAll('.open-lightbox').forEach(icon => {
                icon.style.display = 'block';
            });
        });
    }

    // Boutons précédent et suivant
    if (prevBtn && nextBtn) {
        prevBtn.addEventListener('click', function () {
            currentPhotoIndex = (currentPhotoIndex > 0) ? currentPhotoIndex - 1 : photos.length - 1;
            updateLightbox();
        });

        nextBtn.addEventListener('click', function () {
            currentPhotoIndex = (currentPhotoIndex < photos.length - 1) ? currentPhotoIndex + 1 : 0;
            updateLightbox();
        });
    }

    // Mettre à jour le contenu de la lightbox
    function updateLightbox() {
        const photo = photos[currentPhotoIndex];
        const imgSrc = photo.getAttribute('data-img');
        const title = photo.getAttribute('data-title');
        const cat = photo.getAttribute('data-cat');

        lightboxImg.src = imgSrc;
        lightboxTitle.textContent = title;
        lightboxCat.textContent = cat;
    }

    // Fermer la lightbox en cliquant à l'extérieur
    window.addEventListener('click', function (event) {
        if (event.target === lightbox) {
            lightbox.style.display = 'none';
            document.querySelectorAll('.open-lightbox').forEach(icon => {
                icon.style.display = 'block';
            });
        }
    });
}

    document.querySelectorAll('.icon-center').forEach(function(icon) {
    icon.addEventListener('click', function(event) {
        event.preventDefault();  
        const url = this.closest('a').href; 
        window.location.href = url;  
    });
});




// Initialiser la lightbox au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    initLightbox();
});


