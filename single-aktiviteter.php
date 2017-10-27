<style type="text/css">

.acf-map {
	width: 100%;
	height: 400px;
	border: #ccc solid 1px;
	margin: 20px 0;
}

/* fixes potential theme css conflict */
.acf-map img {
   max-width: inherit !important;
}

</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCmXiAGHZf5ubJyzKPoJA1RURCB0h1uFYM"></script>

<?php get_header(); ?>
<main id="content">
    <!--<h1>Detta är en aktivitet</h1>-->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <!--<?php //get_template_part( 'entry' ); ?> -->
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header>			
			<h1 class="entry-title"> 

			<?php the_title(); ?>	

			</h1>


		</header>

		<div class="entry-content">

		<?php the_content(); ?>
		<?php 

			$address = get_field('address');
			$startDate = get_field('startdatum');
			

			$endDate =get_field('slutdatum');
			$startTime = get_field('starttid');
			$endTime = get_field('sluttid');
			$location = get_field('karta');
			$img = get_field('bild');

			//echo $endDate;

			$dateformatstring = "l d F, Y";
			$unixtimestampStart = strtotime($startDate);
			

			$dag = date_i18n("l", strtotime($startDate));

			echo $dag;
			//$startDate = new DateTime($startDate);
			//date_i18n( 
			//		get_option('date_format'), ($startDate))
			?>
			<div>
				<p>Address: <?php echo $address; ?> </p>
			</div> 
			<div> 
				<p>Starttid: <?php echo $startTime; ?> <br />
				Sluttid: <?php echo $endTime; ?> </p>
			</div>
			<div>
				<?php 
				 	if($endDate): ?>
				 		<p>Startdatum: <?php echo date_i18n($dateformatstring, $unixtimestampStart); ?><br />
					<!--<?php //if ()?>-->
							<?php $unixtimestampEnd = strtotime($endDate); ?>
							Slutdatum: <?php echo date_i18n($dateformatstring, $unixtimestampEnd);  ?> </p>
				 	<?php else : ?>

				 		<p>Datum: <?php echo date_i18n($dateformatstring, $unixtimestampStart)?></p>
				 	<?php endif; ?>

			</div>
			<div>
				<p>Bild: <img src="<?php echo $img['url']; ?>  "></p>
			</div>
			<div>
				Map: <?php echo 'lat: ', $map['lat'], ', lng: ' , $map['lng']; ?>
			</div>

			<?php 

			//$location = get_field('location');

			if( !empty($location) ):
			?>
			<div class="acf-map">
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
			</div>
			<?php endif; ?>

		</div>

		<?php if ( is_singular() ) 
			get_template_part( 'entry-footer' ); ?>
		</article>



<script type="text/javascript">
	(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

});

})(jQuery);
</script>

    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    <?php endwhile; endif; ?>
    <footer class="footer">
        <?php get_template_part( 'nav', 'below-single' ); ?>
    </footer>
</main>
<?php get_footer(); ?>