<?php get_header(); ?>

<main id="primary" class="site-main">
<section class="banner">
     <img src="<?php echo get_stylesheet_directory_uri() . '/images/nathalie-10.jpeg'; ?>" alt="header image" class="hero-header">
     <div class="event-image">
        <img src="<?php echo get_stylesheet_directory_uri() . '/images/PHOTOGRAPHE EVENT.png'; ?>" alt="Photographe event image">
    </div>
</section>  
<div class="homepage-filter"> 
<div id="filter-category" class="filter-dropdown">
            <button class="dropdown-btn">CATÉGORIES</button>
            <ul class="dropdown-list">
            <li data-value="">CATÉGORIES</li>
                <?php
                $categories = get_terms('categories_photos');
                foreach ($categories as $category) {
                    echo '<li data-value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
                }
                ?>
            </ul>
        </div>
    
<div id="filter-category" class="filter-dropdown">
            <button class="dropdown-btn">FORMATS</button>
            <ul class="dropdown-list">
            <li data-value="">FORMATS</li>
                <?php
                $categories = get_terms('format');
                foreach ($categories as $category) {
                    echo '<li data-value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
                }
                ?>
            </ul>
</div>

<div id="filter-category" class="filter-dropdown">
            <button class="dropdown-btn">TRIER PAR</button>
            <ul class="dropdown-list">
            <li data-value="">TRIER PAR</li>
                <?php
                $categories = get_terms('categorie');
                foreach ($categories as $category) {
                    echo '<li data-value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
                }
                ?>
            </ul>
</div>
</div>

<div class="homepage-photos">
    <?php
    // Custom Query pour récupérer les derniers posts de type 'photo'
    $args = array(
        'post_type' => 'photo', //  post type
        'posts_per_page' => 8, 
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
<button id="load-more" class="load-more">Charger plus</button>
</main>
<?php get_footer(); ?>

