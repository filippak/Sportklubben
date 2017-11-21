
<?php
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (!is_plugin_active("profile-builder/index.php")): ?>
  <p> The profile builder plugin must be activated for this theme. </P>
<?php else:
get_header(); ?>

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
<?php get_footer();
endif; ?>
