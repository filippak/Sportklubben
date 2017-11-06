<?php /* Template Name: past-events*/ ?>
 
<?php get_header(); ?>
 
<main id="main" class="l-content" role="main">
    <?php
    $temp = $wp_query; $wp_query= null;
    $args = array('posts_per_page=5', '&paged='.$paged, 'meta_key' => 'startdatum', 'orderby' => 'meta_value', 'order' => 'ASC', 'post_type' => 'aktiviteter');
    $wp_query = new WP_Query($args); 
    $varCheck = 0;
//Kollar om det finns posts
    while ($wp_query->have_posts()) : 
        $wp_query->the_post(); 
    	$thisEndDate = strtotime(get_field('slutdatum'));
    	$todaysDate = strtotime(date(d.m.y));
        $startDate = strtotime(get_field('startdatum'));
    	$eventTypeForThisPast = get_field('engangsforetelse_eller_aterkommande_aktivitet');
//Om datumet passerat
        if($thisEndDate < $todaysDate && $eventTypeForThisPast !== 'aterkommande') :  ?>
            <?php $thisEndDate =strtotime($thisEndDate); ?>
            <h2>
                <a href="<?php the_permalink(); ?>" title="Read more">
                    <?php the_title(); ?>
                </a>
            </h2>
            <?php 
                    if($thisEndDate && $startDate === $thisEndDate): 
                ?>
                    <p>
                        <?php echo date_i18n("D", $startDate);?>
                        <?php echo date_i18n("j", $startDate);?>
                        <?php echo date_i18n("M", $startDate);?>
                        <?php echo date_i18n("Y", $startDate);?>
                    </p>
                <?php
                    else:
                ?>
                    <p>
                        <?php echo date_i18n("D", $startDate);?>-<?php echo date_i18n("D", $thisEndDate);?>
                        <?php echo date_i18n("j", $startDate);?>-<?php echo date_i18n("j", $thisEndDate);?>
                        <?php 
                            if(date_i18n("M", $startDate) !== date_i18n("M", $thisEndDate)):
                                echo date_i18n("M", $startDate);?>-<?php echo date_i18n("M", $thisEndDate);
                            else:
                                echo date_i18n("M", $startDate);
                            endif;
                        ?>
                        <?php 
                            if(date_i18n("Y", $startDate) !== date_i18n("Y", $thisEndDate)):
                                echo date_i18n("Y", $startDate);?> - <?php echo date_i18n("Y", $thisEndDate);
                            else:
                                echo date_i18n("Y", $startDate);
                            endif;
                        ?>
                    </p>
                <?php
                endif;
            ?>
        <?php the_excerpt(); ?>
        <button class="buttonReadMore" onclick="location.href='<?php the_permalink() ?>';">Mer info</button>
        <hr>
        <?php 
    	$varCheck++;
       endif;
    endwhile;
// om inget fanns
    if ($varCheck == 0) {
    	echo "These are not the events you're looking for.";
    	$varCheck = 0;
    }

    if ($paged > 1) : ?>
        <nav id="nav-posts">
            <div class="prev"><?php next_posts_link('&laquo; Previous Posts'); ?></div>
            <div class="next"><?php previous_posts_link('Newer Posts &raquo;'); ?></div>
        </nav>

    <?php endif; ?>
 
    </main> 
 
<?php wp_reset_postdata();?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>