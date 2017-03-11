<?php get_header(); ?>
<section id="content" role="main">


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php endwhile; endif; ?>
</section>
<?php get_footer(); ?>