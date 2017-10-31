<?php get_header();?>
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

<?php
	$contact = get_field('kontakt');
	$contactNo = get_field('kontaktnummer');
	$contactMail = get_field('kontaktemail');

	$website = get_field('hemsida');

	$eventType = get_field('engangsforetelse_eller_aterkommande_aktivitet');

	$startDate = get_field('startdatum');
	$endDate =get_field('slutdatum');
	$startTime = get_field('starttid');
	$endTime = get_field('sluttid');

	$noPeople = get_field('antal');

	$location = get_field('karta');
	$address = $location['address'];
	$img = get_field('bild');

	$dateformatstring = "l d F, Y";
	$unixtimestampStart = strtotime($startDate);
?>
<main class="l-content">
    <h1 class="entry-title">Detta är en aktivitet</h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<!--Wrapper-->
		<div class="entry-content">
			<!--Kartan-->
			<?php if( !empty($location) ): ?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
			<?php endif; ?>
			<!--Titel-->
			<h1 class="entry-title"> 
				<?php the_title(); ?>	
			</h1>
			<!--Platser kvar-->
			<p>Antal platser kvar:<br> 
				<?php 
					if($noPeople && $noPeople !== '0') :
						echo $noPeople; 
					else :
						echo "Fullt";
					endif ;
				?>
			</p>
			<!--Datum-->
			<?php 
				if($endDate && $startDate !== $endDate): 
			?>
			 		<p>
					 	Startdatum: <?php echo date_i18n($dateformatstring, $unixtimestampStart); ?>
						<br />
						<?php $unixtimestampEnd = strtotime($endDate); ?>
						Slutdatum: <?php echo date_i18n($dateformatstring, $unixtimestampEnd);  ?>
					</p>
			<?php 
				else : 
			?>
			 		<p>Datum: <?php echo date_i18n($dateformatstring, $unixtimestampStart)?></p>
			<?php 
				endif;
			 ?>
			<!--Tid -->
			<p>
				Starttid: <?php echo $startTime; ?> <br />
				Sluttid: <?php echo $endTime; ?> 
			</p>
			<!-- Återkommmande-->
				<p>Återkommande event:<br> 
					<?php
						if($eventType == "engangsforeteelse") :
							echo "Nej";
						else :
							//echo $eventType;
							$recurring = get_field('aterkommande');
							
							switch ($recurring) {
								case 'daily':
									echo "Dagligen";
									break;
								case 'weekly':
									echo "Veckovis";
									break;
								case 'monthly':

									$field = get_field_object("occurence");
									$value = $field['value'];
									$labelDay = $field['choices'][$value];

									echo $labelDay;

									$field = get_field_object("manadsvis");
									$value = $field['value'];
									$labelDay = $field['choices'][$value];

									echo " " . $labelDay . " varje månad.";
					
									break;
								case 'yearly':
									echo "Årligen";
									break;
								default:
									echo "Inget valt.";
									break;
							}
						endif; 
					?>
				</p>
			<!--Beskrivningstexten: -->
			<?php the_content(); ?>
			<!--Kontakt: -->
			<div>
				<p>
					Kontaktperson: <?php echo $contact ?> <br />
					Telefonnummer: <?php echo $contactNo; ?> <br />
					Email: <?php echo $contactMail ?>
				</p>
			</div>
			<!--Platsinfo: -->
			<div>
				<p>Address: <?php echo $address; ?> </p>
			</div>
			<div>
				<p>Hemsida: 
					<a target= "_blacnk" href="<?php echo $website; ?>"><?php echo $website; ?></a>
				</p>
			</div>
			<!--Bild:-->
			<div>
				<p><img src="<?php echo $img['url']; ?>  "></p>
			</div>
			<!--Anmälan-->
			<section>
				<h3>Anmälan:</h3>
				<form>
					Förnamn: <br>
					<input type="text" name ="firstname"> <br>
					Efternamn: <br>
					<input type="text" name="lastname"> <br>
					Email: <br>
					<input type="email" name="mail"> <br>
					Personnummer: <br>
					<input type ="text" name ="pnr"><br>
					Hemadress:<br>
					<input type="text" name="homeaddr"><br>
					Startgrupp:<br>
					<input type="text" name="startgroup"><br>
					<input type="submit" value="Submit">				
				</form>
			</section>

		</div>
	</article>
	<script type="text/javascript" src="<?php echo get_home_url();?> /wp-content/themes/Sportklubben/js/googlemaps.js "></script>
    <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
    <?php endwhile; endif; ?>
    <footer class="footer">
        <?php get_template_part( 'nav', 'below-single' ); ?>
    </footer>
</main>
<?php get_sidebar() ?>
<?php get_footer(); ?>