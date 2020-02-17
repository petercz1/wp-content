<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-push-8 col-sm-12 side_bar_padding">
            <?php get_sidebar();?>        
        </div>    
        <div class="col-md-8 col-md-pull-4 col-sm-12">
            <?php if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    the_title( '<h2><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>') ;
                    the_excerpt();
                }
            } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
