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
                   'label' => 'Startdatum',
                   'name' => 'startdatum',
                   'type' => 'date_picker',
                   'date_format' => 'yymmdd',
                   'display_format' => 'dd/mm/yy',
                   'first_day' => 1,
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
                   'key' => 'field_59f2d878baeb6',
                   'label' => 'Starttid',
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
                   'key' => 'field_59f2d89fbaeb7',
                   'label' => 'Sluttid',
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
                    'key' => 'field_59f2d89fba123',
                    'label' => 'Antal platser kvar',
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
                   'key' => 'field_59f2d8e9baeb9',
                   'label' => 'Karta',
                   'name' => 'karta',
                   'type' => 'google_map',
                   'center_lat' => '59.329575',
                   'center_lng' => '17.983804',
                   'zoom' => '',
                   'instructions' => 'Skriv in addressen till eventet',
                   'height' => '',
                   'required' => 1,
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
				'label' => 'Engångsföreteelse eller återkommande aktivitet?',
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
					'daily' => 'Dagligen',
					'weekly' => 'Veckovis',
					'monthly' => 'Månadsvis',
					'yearly' => 'Årligen',
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
					'first' => 'Den första',
					'second' => 'Den andra',
					'third' => 'Den tredje',
					'fourth' => 'Den fjärde',
					'last' => 'Sista',
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
					'mond' => 'måndagen',
					'tues' => 'tisdagen',
					'wednes' => 'onsdagen',
					'thurs' => 'torsdagen',
					'fri' => 'fredagen',
					'satur' => 'lördagen',
					'sun' => 'söndagen',
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

  add_filter('acf/fields/google_map/api', 'my_afc_google_map_api');
