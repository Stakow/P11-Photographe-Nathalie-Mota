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
    wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/js/photo-single.js', array('jquery'), null, true);

}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

