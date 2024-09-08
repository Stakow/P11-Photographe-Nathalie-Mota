document.addEventListener('DOMContentLoaded', function () {

    // Variables globales
    let filters = {
        sort: 'recent',
        category: '',
        format: ''
    };
    let page = 1;

    // Fonction pour mettre à jour les filtres et relancer la récupération des photos
    function updateFilters() {
        const sortBy = document.querySelector('#filter-sort .dropdown-btn').dataset.value;
        const category = document.querySelector('#filter-category .dropdown-btn').dataset.value;
        const format = document.querySelector('#filter-format .dropdown-btn').dataset.value;

        filters.sort = sortBy || 'recent';
        filters.category = category || '';
        filters.format = format || '';


        page = 1;
        fetchPhotos();
    }

    // Fonction pour récupérer les photos via AJAX
    function fetchPhotos() {
        

        const url = `${window.location.origin}/wp-admin/admin-ajax.php?action=fetch_photos&category=${filters.category}&format=${filters.format}&sort=${filters.sort}&page=${page}`;
        

        fetch(url)
            .then(response => response.text())
            .then(data => {
                setTimeout(() => { // Ajout d'un délai pour tester
                    const photoGrid = document.querySelector('.photo-grid');
                   

                    if (photoGrid) {
                        if (page === 1) {
                            photoGrid.innerHTML = data;
                        } else {
                            photoGrid.insertAdjacentHTML('beforeend', data);
                        }
                    } else {
                        console.error('L\'élément photo-grid est introuvable.');
                    }
                },);
            })
            .catch(error => console.error('Erreur lors de la récupération des photos:', error));
    }

    // Initialiser les événements des filtres
    document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
        dropdown.addEventListener('click', function (e) {
            const target = e.target;
            if (target.tagName === 'LI') {
                const dropdownBtn = dropdown.querySelector('.dropdown-btn');
                dropdownBtn.textContent = target.textContent;
                dropdownBtn.dataset.value = target.dataset.value;
                console.log('Filter clicked:', target.textContent, target.dataset.value);
                updateFilters();
            }
        });
    });

    // Gérer les filtres
    const dropdowns = document.querySelectorAll('.filter-dropdown');

    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('.dropdown-btn');
        const items = dropdown.querySelectorAll('li');

        button.addEventListener('click', () => {
            dropdown.classList.toggle('open');
        });

        items.forEach(item => {
            item.addEventListener('click', () => {
                button.textContent = item.textContent;
                button.dataset.value = item.dataset.value;
                dropdown.classList.remove('open');
                updateFilters();
            });
        });
    });

    // Événement pour le bouton "Charger plus"
    document.getElementById('load-more').addEventListener('click', function () {
        page++;
        fetchPhotos();
    });

    // Initialiser la récupération des photos au chargement de la page
    fetchPhotos();
});








