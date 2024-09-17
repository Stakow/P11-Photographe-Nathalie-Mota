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
                    'post_type' => 'photo', 
                    'posts_per_page' => 2, 
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
                            <!-- Icône pour la lightbox -->
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
                            <!-- Insère ici l'icône SVG pour la lightbox -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="24" height="24">
                                <path d="M32 32C14.3 32 0 46.3 0 64l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L32 32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7 14.3 32 32 32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-64zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 0 64c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96c0-17.7-14.3-32-32-32l-96 0zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c17.7 0 32-14.3 32-32l0-96z"/>
                            </svg>
                        </span>

                            <!-- Icône au centre pour afficher plus d'infos -->
                        <a href="<?php the_permalink(); ?>" class="icon-center">
                            <svg class="icon-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="50" height="50">
                                <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
                            </svg>
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