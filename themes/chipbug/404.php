<?php get_header(); ?>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-push-8 col-sm-12 side_bar_padding">
            <?php get_sidebar();?>        
        </div>    
        <div class="col-md-8 col-md-pull-4 col-sm-12">
            <h1>Whoops - nothing at that address...</h1>
            <p>Did you type it in correctly? If so then I probably guffed up - my apologies.</p>
            <p>Try the search box and see if that helps:</p>
            <p id='search_form_on_page'><?php get_search_form(); ?></p>
        </div>
    </div>
</div>

<?php get_footer(); ?>