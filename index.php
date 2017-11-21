

<?php if (!is_plugin_active("profile-builder/index.php")): ?>
  <p> The profile builder plugin must be activated for this theme. </P>
<?php else:
get_header(); ?>


<main class="l-content">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'entry' ); ?>
        <?php comments_template(); ?>
    <?php endwhile; endif; ?>
    <?php get_template_part( 'nav', 'below' ); ?>
</main>
<?php  get_sidebar(); ?>
<?php get_footer();
endif; ?>
