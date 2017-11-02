<?php get_header(); ?>

<main class="l-content">
<?php 
	// Show the selected frontpage content.
	$temp = $wp_query; $wp_query= null;
	$args = array('posts_per_page=5', '&paged='.$paged, 'post_type' => 'aktiviteter');
	$wp_query = new WP_Query($args); 
	while ($wp_query->have_posts()) : $wp_query->the_post(); 
	$eventTypeForThisFront = get_field('engangsforetelse_eller_aterkommande_aktivitet');
	$thisEndDate = strtotime(get_field('slutdatum'));
    $todaysDate = strtotime(date(d.m.y));
    if($eventTypeForThisFront !== "aterkommande" && $thisEndDate > $todaysDate) :  ?>


		<h2>
			<a href="<?php the_permalink(); ?>" title="Read more">
				<?php the_title(); ?>
			</a>
		</h2>
		<?php the_excerpt(); ?>
<?php 
	endif;
	endwhile;
	if ($paged > 1) :
?>
		<nav id="nav-posts">
			<div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
			<div class="next"><?php previous_posts_link('Newer Posts &raquo;'); ?></div>
		</nav>

<?php else : ?>
		<nav id="nav-posts">
			<div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
		</nav>
<?php endif; ?>

</main>
<?php wp_reset_postdata();?>
<?php get_footer(); ?>
