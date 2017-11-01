<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="hfeed l-wrapper">
        <header class="l-header" id ="testHead">
            <div id="branding">
                <div id="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" rel="home">
                        <img src="<?php echo get_template_directory_uri() .'/images/capgemini_logo.png'?>" alt="Capgemini Logo">
                    </a>
                </div>
                <div id="site-description">
                    Sportklubben Stockholm
                </div>
            </div>
            <nav id="menu">
                <div id="search">
                    <?php get_search_form(); ?>
                </div>
                <label class="toggle" for="toggle">&#9776; Menu</label>
                <input id="toggle" class="toggle" type="checkbox" />
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
            </nav>

        </header>

        <div class = "slider">
          <?php masterslider(2); ?>
        </div>
        
        <div class="l-container">
