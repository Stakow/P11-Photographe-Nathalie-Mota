<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <header id="site-header">
        <div id="site-logo">
        <img src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="logo Nathalie Mota" class="site-logo">
        </div>
        <nav id="site-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'main-menu',
                'menu_class'     => 'main-menu', // Classe CSS pour le menu
            ) );
            ?>
        </nav>
    </header>