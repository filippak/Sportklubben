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
                        <img class ="header-Img" src="<?php echo get_template_directory_uri() .'/images/logo_SPORTKLUBBEN_STHLM.png'?>" alt="Capgemini Logo">
                    </a>
                </div>
            </div>
            <nav class="headerNavMenu">
                <label class="toggle" for="toggle">&#9776; Menu</label>
                <input id="toggle" class="toggle" type="checkbox" />
                <?php wp_nav_menu( array( 
                    'theme_location' => 'main-menu',
                    'container' => 'ul',
                    'menu_class' => 'headerNavMenu-UlLink',
                    ) ); 
                ?>
            </nav>

        </header>

<?php if(is_front_page()) :?>
    <div class="bss-slides slideshow snapScroll" >
        <figure class="slideshow-figure" style="background-image: url(<?php  echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-221210.jpg'?>)">
            <figcaption></figcaption>
        </figure>
        <figure  class="slideshow-figure" style="background-image: url(<?php  echo get_template_directory_uri() . '/images/Sliderfoton/freerider-skiing-ski-sports-47356.jpg'?>)">
            <figcaption></figcaption>
        </figure>
        <figure class="slideshow-figure" style="background-image: url(<?php  echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-274506.jpg'?>)">
            <figcaption></figcaption>
        </figure>
        <figure class="slideshow-figure" style="background-image: url(<?php  echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-411207.jpeg'?>)">
            <figcaption></figcaption>
        </figure>
        <!-- more figures here as needed -->
    </div>
    <script>
        var opts = {
                //auto-advancing slides? accepts boolean (true/false) or object
                auto : {
                    // speed to advance slides at. accepts number of milliseconds
                    speed : 7500,
                },
                swipe : true
                };
        makeBSS('.slideshow', opts);
    </script>
    <script>
        // jQuery(function($) {
        //     $.scrollify({
        //         section : ".snapScroll",
        //         offset : -80,
        //         standardScrollElements : ".l-container .l-wrapper"
        //     });
        // });
    </script>
 <?php endif;?>
<div class="l-container snapScroll">
