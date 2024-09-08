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



