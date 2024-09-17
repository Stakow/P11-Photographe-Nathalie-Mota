<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
</head>
<body>
    <header id="site-header">
        <div id="site-logo">
            <img src="<?php echo get_stylesheet_directory_uri() . '/images/logo.png'; ?>" alt="logo Nathalie Mota" class="site-logo">
        </div>
        <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false">
            <span class="line"></span>
            <span class="line"></span>
            <span class="line"></span>
        </button>
        <nav id="site-navigation" class="main-menu">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'main-menu',
                'menu_class'     => 'menu-items', 
            ) );
            ?>
        </nav>
    </header>
    <?php wp_footer(); ?>
</body>
</html>
