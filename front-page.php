<?php get_header(); ?>
<main id="primary" class="site-main">
<section class="banner">
    <?php
    $image_id = 45; 
    $image_size = 'full'; 

    $image = wp_get_attachment_image_src($image_id, $image_size);
    ?>
    <img src="<?php echo esc_url($image[0]); ?>" alt="header image" class="hero-header" loading="lazy">
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
    $order = 'DESC'; // récente //
    if ($sort === 'oldest') {
        $order = 'ASC'; // ancienne //
    }

    $tax_query = array();

    if (!empty($category)) {
        $tax_query[] = array(
            'taxonomy' => 'categories_photos',
            'field' => 'slug',
            'terms' => $category,
        );
    }
    
    if (!empty($format)) {
        $tax_query[] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }
    
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => $tax_query,
    );
    
    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) : ?>
        <div class="photo-grid">
            <?php while ($photo_query->have_posts()) : $photo_query->the_post(); ?>
            <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium'); ?>
                        <?php endif; ?>
                    </a>

                    <!-- Bouton ou icône pour ouvrir la lightbox -->
                    <span class="open-lightbox" 
                        data-img="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
                        data-title="<?php the_title(); ?>" 
                        data-cat="<?php 
                        $categories = get_the_terms(get_the_ID(), 'categories_photos');
                        if ($categories && !is_wp_error($categories)) {
                            $category_names = array();
                            foreach ($categories as $category) {
                                $category_names[] = $category->name;  
                            }
                            echo esc_attr(implode(', ', $category_names));  
                        }
                        ?>">
                        <!-- Insertion de l'icône SVG ici -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
                            <path d="M32 32C14.3 32 0 46.3 0 64l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L32 32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7 14.3 32 32 32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-64zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 0 64c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96c0-17.7-14.3-32-32-32l-96 0zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c17.7 0 32-14.3 32-32l0-96z"/>
                        </svg>
                    </span>
                    <a href="<?php the_permalink(); ?>" class="icon-center">
                        <svg class="icon-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="50" height="50">
                            <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
                        </svg>
                    </a>
                    <div class="photo-info">
                    <!-- Titre de la photo -->
                    <div class="photo-title"><?php the_title(); ?></div>
                    <!-- Catégorie de la photo -->
                    <div class="photo-category">
                    <?php 
                    $categories = get_the_terms(get_the_ID(), 'categories_photos');
                    if ($categories && !is_wp_error($categories)) :
                    $categories_list = array();
                    foreach ($categories as $category) {
                       $categories_list[] = esc_html($category->name);
                    }
                    echo implode(', ', $categories_list);
                    endif;
                    ?>
                    </div>
            </div>
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



