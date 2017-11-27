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
$eventType = get_field('engangsforetelse_eller_aterkommande_aktivitet');
$location = get_field('karta');
if($location):
	$address = $location['address'];
endif;
$img = get_field('bild');
$website = get_field('hemsida');
$startDate = strtotime(get_field('startdatum'));
$endDate =strtotime(get_field('slutdatum'));
$startTime = get_field('starttid');
$endTime = get_field('sluttid');
$noPeople = get_field('antal');
$dateformatstring = "d F, Y";
$unixtimestampStart = strtotime($startDate);

?>
<main class="l-content">
  <!--<h1 class="entry-title">Detta är en aktivitet</h1>-->
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!--Wrapper-->
	<!--Hero bild-->
	<div class="activityHeader">
		<?php if(has_post_thumbnail()) : ?>
			<?php the_post_thumbnail( 'full' ); ?>
		<?php else : ?>
			<img src="<?php echo get_template_directory_uri() . '/images/Sliderfoton/pexels-photo-221210.jpg'?>" alt="Fallback Hero">
		<?php endif ?>
		<!--Date-->
		<div class="activityInfo ">
			<?php if ($eventType === aterkommande):
				$recurring = get_field('aterkommande');
				switch ($recurring) {
					case 'daily': ?>
					<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-size: contain; ">
						<span class="circleDate-recurringDaily"><?php echo "Every day";?></span>
					</div>



						<?php break;
					case 'weekly': ?>
					<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-size: contain; ">
					<span class="circleDate-recurringWeekly"><?php echo "Every ". date_i18n("l", $startDate); ;?></span>
					</div>


					<?php break;
					case 'monthly':
					$field = get_field_object("occurence");
					$value = $field['value'];
					$occurrence = $field['choices'][$value];


					$field = get_field_object("manadsvis");
					$value = $field['value'];
					$labelDay = $field['choices'][$value];
					?>

					<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-size: contain; ">
					<span class="circleDate-recurringMonthly"><?php echo $occurrence . " " . $labelDay . " each month" ;?></span>
					</div>

					<?php break;
					case 'yearly': ?>

					<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-size: contain; ">
					<span class="circleDate-recurringYearly"><?php echo date_i18n("M", $startDate) . " " . date_i18n("d", $startDate) . " every year" ;?></span>
					</div>



			<?php  break;} else:



			if(($endDate && $startDate === $endDate) || !$endDate): ?>

				<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-size: contain; ">
					<div class = "circleDate-dayMonthSingle">
						<span class="circleDate-dayNumberSingle"><?php echo date_i18n("d", $startDate);?></span>
						<span class="circleDate-monthSingle"><?php echo date_i18n("M", $startDate);?></span>
						<span class="circleDate-yearSingle"><?php echo date_i18n("Y", $startDate);?></span>
					</div>
				</div>

			<?php else: ?>
				<div class="timeContainer" style=" background-image:url(<?php echo get_template_directory_uri() . '/images/Picture1.png' ?>); background-repeat: round ">
						<div class = "circleDate-dayMonth">
								<span class="circleDate-dayNumber"><?php echo date_i18n("d", $startDate);?></span>
								<span class="circleDate-month"><?php echo date_i18n("M", $startDate);?></span>
								<span class="circleDate-year"><?php echo date_i18n("Y", $startDate);?></span>
						</div>
					<p class = "circleDate-dateStreck">-</p>
					<div class ="circleDate-dayMonth">
						<span class="circleDate-dayNumber"><?php echo date_i18n("d", $endDate);?></span>
						<span class="circleDate-month"><?php echo date_i18n("M", $endDate);?></span>
						<span class="circleDate-year"><?php echo date_i18n("Y", $endDate);?></span>
					</div>
				</div>
			<?php endif; endif; ?>
			<!--Titel-->
			<div class="activityTitleTime">
				<h1 class="activityTitleTime-title">
					<?php the_title(); ?>
				</h1>
				<p class="activityTitleTime-time">
					<i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $startTime . " - " . $endTime; ?> <br>
					<i style="margin-left:2px; margin-right: 8px;"class="fa fa-map-marker" aria-hidden="true"></i><?php echo $address; ?>
				</p>
			</div>
			<button class="registration">anmälan</button>
		</div>
		<div id="registrationModal" class="modal">
			<!-- Modal content -->
			<div class="modal-content" style="background-image: url(<?php echo get_template_directory_uri() . '/images/redBlueShape.png' ?>)">
				<div class="modal-header">
					<span class="modal-close">&times;</span>
					<h2>Modal Header</h2>
				</div>
				<div class="modal-body">

					<?php  if(!is_user_logged_in() ):
						echo do_shortcode("[wppb-login]");
					else: ?>
						<p>inloggad</p>

					<?php endif; ?>

				</div>
				<div class="modal-footer">
					<h3>Modal Footer</h3>
				</div>
		  	</div>
		</div>
</div>
	<div class="entry-content singleActivityInfo">
		<!-- Återkommmande-->
		<p>
			<?php
				if($eventType == "engangsforeteelse") :
				else :
					?>
					Återkommande: <br><?php
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
		<!--Hemsida-->
		<div>
			<p>Hemsida:
				<a target= "_blacnk" href="<?php echo $website; ?>"><?php echo $website; ?></a>
			</p>
		</div>

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


		<!--Bild:-->
		<div>
			<p><img src="<?php echo $img['url']; ?>  "></p>
		</div>
		<!--Kartan-->
		<?php if( !empty($location) ): ?>
			<div class="acf-map">
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
			</div>
		<?php endif; ?>
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
<div>
		<?php // get_template_part( 'nav', 'below-single' ); ?>
</div>
</main>
<?php get_footer(); ?>
