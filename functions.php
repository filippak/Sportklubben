<?php
    add_action( 'after_setup_theme', 'generic_setup' );
    function generic_setup()
    {
        load_theme_textdomain( 'generic', get_template_directory() . '/languages' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form' ) );
        global $content_width;
        if ( ! isset( $content_width ) )
            $content_width = 640;
            register_nav_menus(
                array( 'main-menu' => esc_html__( 'Main Menu', 'generic' ) )
            );
    }

    add_action( 'wp_enqueue_scripts', 'generic_load_scripts' );
    function generic_load_scripts()
    {
        wp_enqueue_script( 'jquery' );
        wp_register_script( 'generic-videos', get_template_directory_uri() . '/js/videos.js' );
        wp_enqueue_script( 'generic-videos' );

        //för fixed scrolling:
        wp_register_script('fixed',  get_template_directory_uri() . '/js/fixed.js');
        wp_enqueue_script('fixed');

        //för tabs på front page:
        wp_register_script('tabs',  get_template_directory_uri() . '/js/tabs.js');
        wp_enqueue_script('tabs');

        //För Registrationmodal att visas
        wp_register_script('modal', get_template_directory_uri() . '/js/modal.js');
        wp_enqueue_script('modal');
        wp_add_inline_script( 'generic-videos', 'jQuery(document).ready(function($){$("#wrapper").vids();});' );

        //Swiping
        wp_register_script('hammer', get_template_directory_uri() . '/assets/hammer/hammer.min.js');
        wp_enqueue_script('hammer');
        // För simple-slideshow-styles
        wp_register_script('slideshow', get_template_directory_uri() . '/assets/better-simple-slideshow-gh-pages/js/better-simple-slideshow.js');
        wp_enqueue_script('slideshow');
        wp_enqueue_style('slidehow-style', get_template_directory_uri() . '/assets/better-simple-slideshow-gh-pages/css/simple-slideshow-styles.css');

        //Ikoner
        wp_enqueue_style( 'load-fa', get_template_directory_uri() . '/assets/font-awesome-4.7.0/css/font-awesome.min.css' );
        wp_enqueue_style( 'generic-style', get_stylesheet_uri() );

        wp_register_script('scrollify', get_template_directory_uri() . '/assets/scrollify/jquery.scrollify.min.js');
        wp_enqueue_script('scrollify');
    }

    function getEvents($eventType) {
        // Show the selected frontpage content.
        $temp = $wp_query; $wp_query= null;
        $args = array('&paged='.$paged, 'posts_per_page' => -1, 'meta_key' => 'startdatum', 'orderby' => 'meta_value', 'order' => 'ASC', 'post_type' => 'aktiviteter', 'meta_query' => array(
            array(
                'key'     => 'engangsforetelse_eller_aterkommande_aktivitet',
                'value'   => $eventType,
                'compare' => 'EXISTS',
            ),
        ),);
        $wp_query = new WP_Query($args);

        $eventExists = false;
        $eventThisWeek = false;
        $eventThisMonth = false;
        $eventLater = false;

        $posts = get_posts( $args );
        $dateToday = new DateTime(date(Y.m.d));
        $weekToday = $dateToday->format("W");

        while ($wp_query->have_posts()) : 
            $wp_query->the_post();
            $eventTypeForThisFront = get_field('engangsforetelse_eller_aterkommande_aktivitet');
            $thisEndDate = get_field('slutdatum');
            $startDate = strtotime(get_field('startdatum'));
            $todaysDate = date(Y.m.d);
            $dateTest = new DateTime(get_field('startdatum'));
            $weekTest = $dateTest->format("W");
            $thisStartDate = get_field('startdatum');

            if(($eventTypeForThisFront == "engangsforeteelse" && $thisStartDate >= $todaysDate) || ($eventTypeForThisFront == "aterkommande" && $thisStartDate <= $todaysDate && $thisEndDate >= $todaysDate) ) :
                $thisEndDate =strtotime($thisEndDate);
                if ($thisStartDate <= strtotime('30 days') && $eventThisMonth == false) :
                    if ($weekToday == $weekTest && $eventThisWeek == false):
                        echo "<h2>Den här veckan:</h2>";
                        $eventThisWeek = true;
                    elseif($weekToday !== $weekTest) :
                        echo "<h2>Kommande månaden:</h2>";
                        $eventThisMonth = true;
                    endif;
                elseif(strtotime($thisStartDate) > strtotime('30 days') && $eventLater == false) :
                    if($eventThisMonth == true || $eventThisWeek == true):
                        $eventLater = true;
                        echo "<h2>Senare:</h2>";
                    endif;
                endif;
?>
                <div class = frontEvent>
                    <div class="frontEvent-date">
                        <?php if(($thisEndDate && $startDate === $thisEndDate) || !$thisEndDate ) : ?>
                            <p>
                                <?php echo date_i18n("j", $startDate);?>
                                <?php echo strtoupper(date_i18n("M", $startDate));?>
                                <br>
                                <?php echo date_i18n("D", $startDate);?>
                            </p>
                        <?php else:?>
                            <p>
                                <?php 
                                    echo date_i18n("j", $startDate);?>-<?php echo date_i18n("j", $thisEndDate);
                                    if(date_i18n("M", $startDate) !== date_i18n("M", $thisEndDate)) :
                                        echo strtoupper(date_i18n("M", $startDate));?>-<?php echo strtoupper(date_i18n("M", $thisEndDate));
                                    else :
                                        echo strtoupper(date_i18n("M", $startDate));
                                    endif;
                                ?>
                                <br>
                                <?php echo date_i18n("D", $startDate);?>-<?php echo date_i18n("D", $thisEndDate);?>
                            </p>
                        <?php endif; ?>
                    </div>
                    <div class ="frontEvent-content">
                        <h2>
                            <a href="<?php the_permalink(); ?>" title="Read more">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <?php
                            if (strtotime($thisStartDate) < strtotime('30 days') && $eventTypeForThisFront == "engangsforeteelse") :
                                if($weekToday == $weekTest) :
                                    echo ("Den här veckan!");
                                else :
                                    echo ("Inom en månad!");
                                endif;
                            endif;
                            the_excerpt();
                        ?>
                    </div>
                    <button class="frontEvent-readMore" onclick="location.href='<?php the_permalink() ?>';">Mer info</button>
                </div>
                <hr>
<?php
                $eventExists = true;
            endif;
        endwhile;
        if($eventExists == false) :
            echo "<div class='frontEvent-warning'><p><strong>Det finns tyvärr inga inplanerade aktiviteter för tillfället.</strong> <br/><br/> Följ vårat nyhetsbrev (?) för att få uppdateringar när vi lägger upp nya aktiviteter!</p></div>";            
        endif;
    }

    add_filter( 'document_title_separator', 'generic_document_title_separator' );
    function generic_document_title_separator( $sep ) {
        $sep = "|";
        return $sep;
    }

    add_filter( 'the_title', 'generic_title' );
    function generic_title( $title ) {
        if ( $title == '' ) {
            return '&rarr;';
        } else {
            return $title;
        }
    }

    function generic_read_more_link() {
        if ( ! is_admin() ) {
            return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
        }
    }

    add_filter( 'the_content_more_link', 'generic_read_more_link' );
    function generic_excerpt_read_more_link( $more ) {
        if ( ! is_admin() ) {
            global $post;
            return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
        }
    }

    add_filter( 'excerpt_more', 'generic_excerpt_read_more_link' );
    add_action( 'widgets_init', 'generic_widgets_init' );
    function generic_widgets_init()
    {
        register_sidebar( array (
            'name' => esc_html__( 'Sidebar Widget Area', 'generic' ),
            'id' => 'primary-widget-area',
            'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
            'after_widget' => "</li>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }

    function checkPlugins()
    {
        if (!is_plugin_active("profile-builder/index.php"))
        {
            echo '<div class="error notice"><p>The theme Sportklubben requires the plugin Profile Builder. <a target="_blank" href="https://wordpress.org/plugins/profile-builder/">Download and Activate Profile builder.<a></p></div>';
        }
    }
    add_action( 'admin_notices', 'checkPlugins' );

    add_action( 'comment_form_before', 'generic_enqueue_comment_reply_script' );
    function generic_enqueue_comment_reply_script()
    {
        if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
    }

    function generic_custom_pings( $comment )
    {
?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
    }

    add_filter( 'get_comments_number', 'generic_comment_count', 0 );
    function generic_comment_count( $count ) {
        if ( ! is_admin() ) {
            global $id;
            $get_comments = get_comments( 'status=approve&post_id=' . $id );
            $comments_by_type = separate_comments( $get_comments );
            return count( $comments_by_type['comment'] );
        } else {
            return $count;
        }
    }

// Our custom post type function
    function create_posttype() {

       register_post_type( 'Aktiviteter',
       // CPT Options
           array(
               'labels' => array(
                   'name' => __( 'Aktiviteter' ),
                   'singular_name' => __( 'Aktivitet' )
               ),
               'public' => true,
               'has_archive' => true,
               'rewrite' => array('slug' => 'aktiviteter'),
               'taxonomies' => array('category' ),
               'supports' => array('thumbnail','title', 'editor')
           )
       );
   }
   // Hooking up our function to theme setup
   add_action( 'init', 'create_posttype' );

   show_admin_bar(false);

	function create_custom_taxonomies() {
        wp_create_category('Bollsport');
        wp_create_category('E-sport');
        wp_create_category('Föredrag');
        wp_create_category('Friluftsliv');
        wp_create_category('Konditionsträning');
        wp_create_category('Löpning');
        wp_create_category('Motionslopp');
        wp_create_category('Prova på!');
        wp_create_category('Racketsporter');
        wp_create_category('Styrketräning');
        wp_create_category('Vattensport');
        wp_create_category('Veckoaktiviteter');
        wp_create_category('Vintersport');
        wp_create_category('Yoga');
	}

	   add_action( 'admin_init', 'create_custom_taxonomies' );
   include_once('assets/advanced-custom-fields/acf.php');
  // include_once('master-slider/master-slider.php');

   if(function_exists("register_field_group"))
   {
       register_field_group(array (
           'id' => 'acf_aktivitet',
           'title' => 'Aktivitet',
           'fields' => array (
               array (
                   'key' => 'field_59f2d6d4109de',
                   'label' => 'Startdatum (Required)',
                   'name' => 'startdatum',
                   'type' => 'date_picker',
                   'date_format' => 'yymmdd',
                   'display_format' => 'dd/mm/yy',
                   'first_day' => 1,
                   'required' => 1,
               ),
               array (
                    'key' => 'field_59f2d878baeb6',
                    'label' => 'Starttid (Required)',
                    'name' => 'starttid',
                    'type' => 'text',
                    'instructions' => 'Format: hh:mm',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                    'required' => 1,
               ),
               array (
                   'key' => 'field_59f2d7e0109df',
                   'label' => 'Slutdatum',
                   'name' => 'slutdatum',
                   'type' => 'date_picker',
                   'date_format' => 'yymmdd',
                   'display_format' => 'dd/mm/yy',
                   'first_day' => 1,
               ),
               array (
                   'key' => 'field_59f2d89fbaeb7',
                   'label' => 'Sluttid (Required)',
                   'name' => 'sluttid',
                   'type' => 'text',
                   'instructions' => 'Format: hh:mm',
                   'default_value' => '',
                   'placeholder' => '',
                   'prepend' => '',
                   'append' => '',
                   'formatting' => 'html',
                   'maxlength' => '',
                   'required' => 1,
               ),
               array (
                   'key' => 'field_59f2d7e0109dfx123',
                   'label' => 'Sista dag att registrera sig:',
                   'name' => 'lastdayosa',
                   'type' => 'date_picker',
                   'date_format' => 'yymmdd',
                   'display_format' => 'dd/mm/yy',
                   'first_day' => 1,
               ),
                array (
                   'key' => 'field_59f2d8e9baeb9',
                   'label' => 'Adress (Required)',
                   'name' => 'karta',
                   'type' => 'google_map',
                   'center_lat' => '59.329575',
                   'center_lng' => '17.983804',
                   'zoom' => '',
                   'instructions' => 'Skriv in adressen till eventet eller välj via kartan',
                   'height' => '',
                   'required' => 1,
               ),
                array (
                    'key' => 'field_59f2d89fba123',
                    'label' => 'Antal lediga platser',
                    'name' => 'antal',
                    'type' => 'number',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'formatting' => 'html',
                    'maxlength' => '',
                ),
                array (
                   'key' => 'field_59f2d89fbaebz',
                   'label' => 'Kontaktperson',
                   'name' => 'kontakt',
                   'type' => 'text',
                   'instructions' => 'Vem man ska kontakta om man vill veta mer',
                   'default_value' => '',
                   'placeholder' => '',
                   'prepend' => '',
                   'append' => '',
                   'formatting' => 'html',
                   'maxlength' => '',
               ),
               array (
                   'key' => 'field_59f2d89fbaebz1',
                   'label' => 'Kontaktpersonens telefonnummer',
                   'name' => 'kontaktnummer',
                   'type' => 'text',
                   'instructions' => 'Telefonnummer till kontaktpersonen',
                   'default_value' => '',
                   'placeholder' => '',
                   'prepend' => '',
                   'append' => '',
                   'formatting' => 'html',
                   'maxlength' => '',
                ),
                array (
                   'key' => 'field_59f2d89fbaebz13',
                   'label' => 'Kontaktpersonens email',
                   'name' => 'kontaktemail',
                   'type' => 'text',
                   'instructions' => 'Email till kontaktpersonen',
                   'default_value' => '',
                   'placeholder' => '',
                   'prepend' => '',
                   'append' => '',
                   'formatting' => 'html',
                   'maxlength' => '',
                ),
               array (
                   'key' => 'field_59f2d89fbaebz12',
                   'label' => 'Hemsida',
                   'name' => 'hemsida',
                   'type' => 'text',
                   'instructions' => 'Hemsida till eventet eller dom som håller i eventet om man vill veta mer',
                   'default_value' => 'http://',
                   'placeholder' => '',
                   'prepend' => '',
                   'append' => '',
                   'formatting' => 'html',
                   'maxlength' => '',
                ),
               array (
                   'key' => 'field_59f2d913baeba',
                   'label' => 'Bild',
                   'name' => 'bild',
                   'type' => 'image',
                   'save_format' => 'object',
                   'preview_size' => 'thumbnail',
                   'library' => 'all',
               ),
           ),
           'location' => array (
               array (
                   array (
                       'param' => 'post_type',
                       'operator' => '==',
                       'value' => 'aktiviteter',
                       'order_no' => 0,
                       'group_no' => 0,
                   ),
               ),
           ),
           'options' => array (
               'position' => 'normal',
               'layout' => 'no_box',
               'hide_on_screen' => array (
               ),
           ),
           'menu_order' => 0,
       ));
   }

   if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_engangsforeteelse-eller-aterkommande',
		'title' => 'Engångsföreteelse eller återkommande?',
		'fields' => array (
			array (
				'key' => 'field_59f7001f4c0a1',
				'label' => 'Engångsföreteelse eller återkommande aktivitet? (Required)',
				'name' => 'engangsforetelse_eller_aterkommande_aktivitet',
				'type' => 'radio',
				'instructions' => 'Om man väljer veckoligen kommer den återskapas samma veckodag varje vecka, om man återskapar den dagligen kommer den läggas in varje dag, inklusive helger.',
				'choices' => array (
					'engangsforeteelse' => 'Engångsföreteelse',
					'aterkommande' => 'Återkommande',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'Engångsföreteelse',
				'layout' => 'vertical',
				'required' => 1,
			),
			array (
				'key' => 'field_59f700474c0a2',
				'label' => 'Återkommande',
				'name' => 'aterkommande',
				'type' => 'radio',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59f7001f4c0a1',
							'operator' => '==',
							'value' => 'aterkommande',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'daily' => 'daily',
					'weekly' => 'weekly',
					'monthly' => 'monthly',
					'yearly' => 'yearly',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'horizontal',
			),
			array (
				'key' => 'field_59f73cc5c1be9',
				'label' => 'Occurence',
				'name' => 'occurence',
				'type' => 'radio',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59f700474c0a2',
							'operator' => '==',
							'value' => 'monthly',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'first' => 'The first',
					'second' => 'The second',
					'third' => 'The third',
					'fourth' => 'The fourth',
					'last' => 'The last',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => '',
				'layout' => 'horizontal',
			),

			array (
				'key' => 'field_59f7009f4c0a3',
				'label' => 'Månadsvis',
				'name' => 'manadsvis',
				'type' => 'radio',
				'instructions' => 'Den första ',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_59f700474c0a2',
							'operator' => '==',
							'value' => 'monthly',
						),
					),
					'allorany' => 'all',
				),
				'choices' => array (
					'mond' => 'monday',
					'tues' => 'tuesday',
					'wednes' => 'wednesday',
					'thurs' => 'thursday',
					'fri' => 'friday',
					'satur' => 'saturday',
					'sun' => 'sunday',
				),
				'default_value' => '',
				'layout' => 'horizontal',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'aktiviteter',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => -1,
	));
}


  function my_afc_google_map_api($api) {
    $api['key'] = 'AIzaSyCmXiAGHZf5ubJyzKPoJA1RURCB0h1uFYM';

    return $api;
  }

  // add_action( 'template_redirect', function() {
  //
  //     if( ( !is_page('log-on-page') ) ) {
  //
  //         if (!is_user_logged_in() ) {
  //             wp_redirect( site_url( '/log-on-page' ) );        // redirect all...
  //             exit();
  //         }
  //
  //     }
  //
  // });
