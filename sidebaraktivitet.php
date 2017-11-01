<aside class="l-sidebar">
    <?php if ( is_active_sidebar( 'primary-widget-area' ) ) : ?>
    <!--This is sidebar2-->
        <div id ="wrapper">
        	<?php
				$website = get_field('hemsida');

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
	<!--Kartan-->
			<?php if( !empty($location) ): ?>
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
			<?php endif; ?>	

	<!--Platsinfo: -->
			<div>
				<p>Address: <?php echo $address; ?> </p>
			</div>

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
	<!--Tid -->
			<p>
				Starttid: <?php echo $startTime; ?> <br />
				Sluttid: <?php echo $endTime; ?> 
			</p>

	<!--NAV nästa inlägg-->
			<div>
       		 	<?php get_template_part( 'nav', 'below-single' ); ?>
       		</div>

        </div>
        
    <?php endif; ?>
</aside>
