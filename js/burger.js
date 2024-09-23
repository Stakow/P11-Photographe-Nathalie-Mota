document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.querySelector('.menu-toggle');
    var siteNavigation = document.querySelector('#site-navigation');
    var body = document.body;

    if (menuToggle && siteNavigation) {
        menuToggle.addEventListener('click', function() {
            var isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
            
            if (isOpen) {
                // Si le menu est ouvert, ajoute la classe 'closing' pour l'animation de fermeture
                siteNavigation.classList.add('closing');
                
                // "réinitialiser l'animation"
                setTimeout(function() {
                    siteNavigation.classList.remove('open');
                    siteNavigation.classList.remove('closing'); 
                }, 300); 
            } else {
                // Ouvre le menu
                siteNavigation.classList.add('open');
            }
            menuToggle.classList.toggle('active');
            
            // Met à jour l'attribut 'aria-expanded'
            menuToggle.setAttribute('aria-expanded', !isOpen);
            
            // Bloque ou débloque le scroll
            body.classList.toggle('no-scroll', !isOpen);
        });
    } else {
        console.error('Menu toggle or site navigation not found.');
    }
});


