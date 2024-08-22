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
                <?php endif; ?>

                <?php if (get_field('categories')) : ?> 
                    <p><strong>Catégories :</strong> <?php the_field('categories'); ?></p> 
                <?php endif; ?>

                <?php if (get_field('formats')) : ?> 
                    <p><strong>Format :</strong> <?php the_field('formats'); ?></p> 
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
        <div class="interaction-block-1"><p class="interaction-text">Cette photo vous intéresse ?</p></div>
        <div class="interaction-block-2"><a href="#contact-modal" class="contact-button">Contact</a></div>
        <div class="interaction-block-3">
            <button class="nav-button prev-button">&#9664;</button>
            <div class="thumbnail">
                <!-- Image miniature de l'article au hasard -->
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/Logo.png'; ?>" alt="Miniature">
            </div>
            <button class="nav-button next-button">&#9654;</button>
        </div>
    </div>


</main>

<?php get_footer(); ?>