<?php /* Template Name: AterkommandeEvent*/ ?>
 
<?php get_header(); ?>
 
<div id="primary" class="content-area">
    <main id="main" class="l-content" role="main">
        <?php

 
    $temp = $wp_query; $wp_query= null;
    $args = array('posts_per_page=5', '&paged='.$paged, 'post_type' => 'aktiviteter');
    $wp_query = new WP_Query($args); 
    $varCheck = 0;

    while ($wp_query->have_posts()) : $wp_query->the_post(); 
                $eventTypeForThis = get_field('engangsforetelse_eller_aterkommande_aktivitet');
        if($eventTypeForThis == "aterkommande") :  ?>

        <h2>
            <a href="<?php the_permalink(); ?>" title="Read more">
                <?php the_title(); ?>
            </a>
        </h2>
        <?php the_excerpt(); ?>
    <?php 
        $varCheck++;
        endif;
    endwhile;
    if ($paged > 1) :
?>
        <nav id="nav-posts">
            <div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
            <div class="next"><?php previous_posts_link('Newer Posts &raquo;'); ?></div>
        </nav>




 <?php   endif; 
        if ($varCheck == 0) {
        echo "These are not the events you're looking for.";
        $varCheck = 0;
    }
      ?>
 
    </main><!-- .site-main -->
 
 
</div><!-- .content-area -->

<?php wp_reset_postdata();?> 

<?php get_footer(); ?>