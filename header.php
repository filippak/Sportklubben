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

        <div class="bss-slides slideshow">
          <figure>
            <img src="<?php echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-221210.jpg'?>" width="100%" />
            <figcaption></figcaption>
          </figure>
          <figure>
            <img src="<?php echo get_template_directory_uri() . '/images/Sliderfoton/freerider-skiing-ski-sports-47356.jpg'?>" width="100%" />
            <figcaption></figcaption>
          </figure>
          <figure>
            <img src="<?php echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-274506.jpg'?>" width="100%" />
            <figcaption></figcaption>
          </figure>
          <figure>
            <img src="<?php echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-411207.jpeg'?>" width="100%" />
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

                   }
                };


          makeBSS('.slideshow', opts);
        </script>



        <div class="l-container">
