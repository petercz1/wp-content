<form action="<?php echo home_url('/'); ?>" method='get' class="navbar-form navbar-right">
    <div id="form_controls">
        <div class="form-group">
            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </div>
</form>
