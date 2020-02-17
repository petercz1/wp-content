<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-push-8 col-sm-12 side_bar_padding">
            <?php get_sidebar();?>
        </div>
        <div class="col-md-8 col-md-pull-4 col-sm-12">
            <?php  
            while ( have_posts() ) : the_post();
                the_title( '<h1>', '</h1>' );
                the_content();
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
            endwhile;
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
