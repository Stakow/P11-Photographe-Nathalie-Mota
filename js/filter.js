// Fonction pour gérer les dropdowns
const dropdowns = document.querySelectorAll('.filter-dropdown');

dropdowns.forEach(dropdown => {
    const button = dropdown.querySelector('.dropdown-btn');
    const list = dropdown.querySelector('.dropdown-list');
    const items = list.querySelectorAll('li');

    // Ouvrir/fermer la liste déroulante
    button.addEventListener('click', () => {
        dropdown.classList.toggle('open');
    });

    // Sélectionner un élément dans la liste déroulante
    items.forEach(item => {
        item.addEventListener('click', () => {
            button.textContent = item.textContent;
            button.dataset.value = item.dataset.value;
            dropdown.classList.remove('open');
            updateFilters(); // Mettre à jour les filtres après sélection
        });
    });

    // Fermer la liste si on clique en dehors
    document.addEventListener('click', function(event) {
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('open');
        }
    });
});

// Fonction pour mettre à jour les filtres dans l'URL
function updateFilters() {
    const sortBy = document.querySelector('#filter-sort .dropdown-btn').dataset.value;
    const category = document.querySelector('#filter-category .dropdown-btn').dataset.value;
    const format = document.querySelector('#filter-format .dropdown-btn').dataset.value;

    const url = new URL(window.location.href);

    // Mettre à jour l'URL avec les nouveaux paramètres
    if (sortBy) {
        url.searchParams.set('sort', sortBy);
    }
    if (category) {
        url.searchParams.set('category', category);
    }
    if (format) {
        url.searchParams.set('format', format);
    }

    // Rediriger vers la nouvelle URL
    window.location.href = url.toString();
};
