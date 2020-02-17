<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-push-8 col-sm-12 side_bar_padding">
            <?php get_sidebar();?>
        </div>
        <div class="col-md-8 col-md-pull-4 col-sm-12">
            <?php
            if ( have_posts() ) {
                while ( have_posts() ) {
                    the_post();
                    the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>') ;
                    the_excerpt();
                }
            }
            ?>
            <?php if (!have_posts()): ?>
            <article id="post-0">
                <header>
                    <h3>No posts found.</h3>
                </header>
                <!-- end article header -->

                <section class="post_content">
                    <p>Sorry, nothing found for your search.</p>
                    <p>Try again, or use the menus...</p> 
                </section>
                <!-- end article section -->

                <footer>
                </footer>
                <!-- end article footer -->

            </article>
            <!-- end article -->
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
