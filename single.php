<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="single-content-wrapper">
        <!-- Section gauche : Titre et détails de la photo -->
        <div class="single-content-left">
            <div class="single-content-pos">
            <h1 class="single-title"><?php the_title(); ?></h1>
            
            <div class="acf-fields">
                <?php if (get_field('reference')) : ?> 
                    <p><strong>Référence :</strong> <?php the_field('reference'); ?></p> 
                    <?php
                        // Ajoutez cet élément pour stocker la référence de la photo
                        $photo_reference = get_field('reference');
                        ?>
                        <div id="photo-reference" data-reference="<?php echo esc_attr($photo_reference); ?>" style="display: none;"></div>
                <?php endif; ?>

                <?php
                // Afficher les termes de la taxonomie "catégories-photos"
                $categories = get_the_terms(get_the_ID(), 'categories_photos');
                if ($categories && !is_wp_error($categories)) :
                ?>
                    <p><strong>Catégories :</strong> 
                    <?php
                    $categories_list = array();
                    foreach ($categories as $category) {
                        $categories_list[] = esc_html($category->name);
                    }
                    echo implode(', ', $categories_list);
                    ?>
                    </p>
                <?php endif; ?>

                <?php
                // Afficher les termes de la taxonomie "formats"
                $formats = get_the_terms(get_the_ID(), 'format');
                if ($formats && !is_wp_error($formats)) :
                ?>
                    <p><strong>Format :</strong> 
                    <?php
                    $formats_list = array();
                    foreach ($formats as $format) {
                        $formats_list[] = esc_html($format->name);
                    }
                    echo implode(', ', $formats_list);
                    ?>
                    </p>
                <?php endif; ?>

                <?php if (get_field('type')) : ?> 
                    <p><strong>Type :</strong> <?php the_field('type'); ?></p> 
                <?php endif; ?>

                <?php if (get_field('annee')) : ?> 
                    <p><strong>Année :</strong> <?php the_field('annee'); ?></p> 
                <?php endif; ?>
            </div>
            </div>
        </div>

        <!-- Section droite : Image -->
        <div class="single-content-right">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('full'); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="interaction-block">
        <div class="interaction-second-block-1">
        <div class="interaction-block-1"><p class="interaction-text">Cette photo vous intéresse ?</p></div>
        <div class="interaction-block-2"><a href="#contact-modal" class="contact-button">Contact</a></div>
        </div>
        <div class="interaction-block-3">
        <?php
            // Récupérer l'article précédent et suivant en fonction de la date
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            ?>

            <!-- Section pour afficher la miniature -->
            <div class="thumbnail-miniature">
                <img src="" alt="Miniature" id="thumbnail-image">
            </div>

            <div class="arrow-position">
            <?php if (!empty($prev_post)) : ?>
                <!-- Bouton pour l'article précédent avec l'URL de l'article -->
                <button class="nav-button prev-button" 
                        data-thumbnail="<?php echo get_the_post_thumbnail_url($prev_post->ID, 'thumbnail'); ?>" 
                        data-url="<?php echo get_permalink($prev_post->ID); ?>" 
                        aria-label="Article précédent">
                    &#9664;
                </button>
            <?php endif; ?>


            <?php if (!empty($next_post)) : ?>
                <!-- Bouton pour l'article suivant avec l'URL de l'article -->
                <button class="nav-button next-button" 
                        data-thumbnail="<?php echo get_the_post_thumbnail_url($next_post->ID, 'thumbnail'); ?>" 
                        data-url="<?php echo get_permalink($next_post->ID); ?>" 
                        aria-label="Article suivant">
                    &#9654;
                </button>

            <?php endif; ?>
            </div>
        </div>
    </div>

     
    <div class="similar-photos">
        <div class="title-photos">
            <h2>VOUS AIMEREZ AUSSI</h2>
        </div>
        <div class="photo-grid">
            <?php
            // Récupérer les catégories de l'article actuel
            $categories = wp_get_post_terms(get_the_ID(), 'categories_photos', array('fields' => 'ids'));
            
            if ($categories) :
                // Custom Query pour récupérer les photos similaires
                $args = array(
                    'post_type' => 'photo', // Post type
                    'posts_per_page' => 2, // Nombre de photos à afficher
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'categories_photos',
                            'field'    => 'term_id',
                            'terms'    => $categories,
                        ),
                    ),
                    'post__not_in' => array(get_the_ID()), // Exclure l'article actuel
                );

                $similar_photos_query = new WP_Query($args);

                if ($similar_photos_query->have_posts()) :
                    while ($similar_photos_query->have_posts()) : $similar_photos_query->the_post(); ?>
                        <div class="photo-item">
                            <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('full'); ?>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endwhile;
                else : ?>
                    <p>Aucune photo similaire trouvée.</p>
                <?php endif; 
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>