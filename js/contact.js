document.addEventListener('DOMContentLoaded', function() {
    const contactLink = document.querySelector('a[href="#"]');
    const modal = document.querySelector('#contact-modal');
    const closeModal = document.querySelector('#close-modal');

    if (contactLink && modal) {
        contactLink.addEventListener('click', function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        });
    }

    if (closeModal && modal) {
        closeModal.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    }

    if (modal) {
        window.addEventListener('click', function(e) {
            if (e.target == modal) {
                modal.style.display = 'none';
            }
        });
    }
});







