const dropdowns = document.querySelectorAll('.filter-dropdown');

    dropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('.dropdown-btn');
        const list = dropdown.querySelector('.dropdown-list');
        const items = list.querySelectorAll('li');

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

        document.addEventListener('click', function(event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('open');
            }
        });
    });