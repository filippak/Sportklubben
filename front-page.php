<?php get_header(); ?>
<main class="l-content">
<div class="tab">
  <button class="tablinks active" onclick="openCity(event, 'Upcoming')">Kommande aktiviteter</button>
  <button class="tablinks" onclick="openCity(event, 'Ongoing')">Återkommande aktiviteter</button>
</div>


<div id="Upcoming" class="tabcontent">
	<?php getEvents('engangsforeteelse');?>
</div>
<div id="Ongoing" class="tabcontent">
	<?php getEvents('aterkommande');?>
</div>

</main>
<?php wp_reset_postdata();?>
<?php get_footer(); ?>
