<?php get_header(); ?>

<div class="homepage-photos">
    
    <?php
    // Custom Query pour récupérer les derniers posts de type 'photo'
    $args = array(
        'post_type' => 'photo', // Assurez-vous que 'photo' est bien votre post type
        'posts_per_page' => 8, // Nombre de photos à afficher
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

<?php get_footer(); ?>

