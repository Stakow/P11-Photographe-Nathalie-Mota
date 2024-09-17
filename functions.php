<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// Ajouter le support pour les balises de titre
add_theme_support('title-tag');

// Enregistrer et enfiler le fichier style.css
function enqueue_my_styles() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'enqueue_my_styles' );

// Enregistrer le menu principal
function register_my_menu() {
    register_nav_menus( array(
        'main-menu' => __( 'Menu principal', 'text-domain' ),
    ) );
}
add_action( 'after_setup_theme', 'register_my_menu' );

// Ajouter des attributs title et aria-current aux éléments de menu
function customize_menu_attributes($atts, $item, $args) {
    // Ajouter l'attribut title
    if (isset($item->title)) {
        $atts['title'] = $item->title;
    }

    // Ajouter l'attribut aria-current pour les éléments de menu actifs
    if (in_array('current-menu-item', $item->classes) || in_array('current-menu-ancestor', $item->classes)) {
        $atts['aria-current'] = 'page';
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'customize_menu_attributes', 10, 3);

// intégré js
function enqueue_custom_scripts() {
    wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/js/contact.js', array('jquery'), null, true);
    wp_enqueue_script('photo-scripts', get_stylesheet_directory_uri() . '/js/photo-single.js', array('jquery'), null, true);
    wp_enqueue_script('filter-scripts', get_stylesheet_directory_uri() . '/js/filter.js', array('jquery'), null, true);
    wp_enqueue_script('burger-scripts', get_stylesheet_directory_uri() . '/js/burger.js', array('jquery'), null, true);
    wp_enqueue_script('lightbox-scripts', get_stylesheet_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);


}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function fetch_photos() {
    $category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
    $format = isset($_GET['format']) ? sanitize_text_field($_GET['format']) : '';
    $sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'recent';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $order = $sort === 'oldest' ? 'ASC' : 'DESC';

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $page,
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => array(
            'relation' => 'AND',
        ),
    );

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categories_photos',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format,
        );
    }

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post(); ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('full'); ?>
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
        <?php endwhile;
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_reset_postdata();
    wp_die(); // Stop AJAX execution
}
add_action('wp_ajax_fetch_photos', 'fetch_photos');
add_action('wp_ajax_nopriv_fetch_photos', 'fetch_photos');



