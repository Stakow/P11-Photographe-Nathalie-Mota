<?php get_header(); ?>
<main id="primary" class="site-main">
<section class="banner">
    <img src="<?php echo get_stylesheet_directory_uri() . '/images/nathalie-10.jpeg'; ?>" alt="header image" class="hero-header">
    <div class="event-image">
        <img src="<?php echo get_stylesheet_directory_uri() . '/images/PHOTOGRAPHE EVENT.png'; ?>" alt="Photographe event image">
    </div>
</section>  

<div class="homepage-filter">
    <div class="homepage-filter-2">
    <!-- Catégories -->
    <div id="filter-category" class="filter-dropdown">
        <button class="dropdown-btn">CATÉGORIES</button>
        <ul class="dropdown-list">
            <li data-value="">Toutes les catégories</li>
            <?php
            $categories = get_terms('categories_photos');
            foreach ($categories as $category) {
                echo '<li data-value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Formats -->
    <div id="filter-format" class="filter-dropdown">
        <button class="dropdown-btn">FORMATS</button>
        <ul class="dropdown-list">
            <li data-value="">Tous les formats</li>
            <?php
            $formats = get_terms('format');
            foreach ($formats as $format) {
                echo '<li data-value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</li>';
            }
            ?>
        </ul>
    </div>
        </div>

    <!-- Trier par -->
    <div id="filter-sort" class="filter-dropdown">
        <button class="dropdown-btn">TRIER PAR</button>
        <ul class="dropdown-list">
            <li data-value="recent">Plus récente</li>
            <li data-value="oldest">Plus ancienne</li>
        </ul>
    </div>
</div>

<div class="homepage-photos">
    <?php
    // Custom Query pour récupérer les derniers posts de type 'photo'
    // Récupérer les paramètres de tri, catégorie et format de l'URL
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';

    // Définir l'ordre de tri en fonction du paramètre
    $order = 'DESC'; // Par défaut, trier par la plus récente
    if ($sort === 'oldest') {
        $order = 'ASC'; // Trier par la plus ancienne
    }

    // Arguments pour WP_Query
    $args = array(
        'post_type' => 'photo', //  post type
        'post_type' => 'photo', // post type
        'posts_per_page' => 8, 
        'orderby' => 'date',
        'order' => $order, // Appliquer l'ordre de tri
        'tax_query' => array(
            'relation' => 'AND', // Relation entre les taxonomies
            // Filtrer par catégorie, si un paramètre de catégorie est défini
            !empty($category) ? array(
                'taxonomy' => 'categories_photos', 
                'field' => 'slug',
                'terms' => $category
            ) : '',
            // Filtrer par format, si un paramètre de format est défini
            !empty($format) ? array(
                'taxonomy' => 'format', 
                'field' => 'slug',
                'terms' => $format
            ) : '',
        ),
    );

    $photo_query = new WP_Query($args);
    if ($photo_query->have_posts()) : ?>
        <div class="photo-grid">
            <?php while ($photo_query->have_posts()) : $photo_query->the_post(); ?>
                <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full'); ?>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else : ?>
        <p>Aucune photo trouvée.</p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>
<div class="homepage-button">
    <button id="load-more" class="load-more">Charger plus</button>
</div>
</main>

<?php get_footer(); ?>


