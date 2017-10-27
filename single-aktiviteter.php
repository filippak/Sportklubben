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

			//$address = get_field('address');
			$contact = get_field('kontakt');
			$contactNo = get_field('kontaktnummer');
			$contactMail = get_field('kontaktemail');

			$website = get_field('hemsida');

			$eventType = get_field('radiobtn');

			$startDate = get_field('startdatum');
			$endDate =get_field('slutdatum');
			$startTime = get_field('starttid');
			$endTime = get_field('sluttid');


			$location = get_field('karta');
			$address = $location['address'];
			$img = get_field('bild');

			//echo $endDate;

			$dateformatstring = "l d F, Y";
			$unixtimestampStart = strtotime($startDate);
			

			//$dag = date_i18n("l", strtotime($startDate));

			?>
			<!--Se om recurring => funktionalitet-->
			<div>
				<p>Återkommande event: <?php
					if($eventType == "Recurring") :
						echo "Ja";
					else :
						echo "Nej";
					endif; ?></p>
			</div>
			<!--Kontakt: -->
			<div>
				<p>Kontaktperson: <?php echo $contact ?> <br />
				Telefonnummer: <?php echo $contactNo; ?> <br />
				Email: <?php echo $contactMail ?></p>
			</div>
			<!--Platsinfo: -->
			<div>
				<p>Address: <?php echo $address; ?> </p>
				<?php 
				if( !empty($location) ):
				?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
				<?php endif; ?>
			</div>
			<div>
				<p>Hemsida: <a target= "_blacnk" href="<?php echo $website; ?>"><?php echo $website; ?> </a>
				</p>
			</div>
			<!--Tid-->
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

			<!--Bild:-->
			<div>
				<p><img src="<?php echo $img['url']; ?>  "></p>
			</div>
			

		</div>

		</article>

		<script type="text/javascript" src="<?php echo get_home_url();?> /wp-content/themes/Sportklubben/js/googlemaps.js ">
		</script>
    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    <?php endwhile; endif; ?>
    <footer class="footer">
        <?php get_template_part( 'nav', 'below-single' ); ?>
    </footer>
</main>
<?php get_footer(); ?>