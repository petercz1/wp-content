<?php if(current_user_can( 'manage_options' )){ ?>
<nav class="navbar navbar-default">
    <?php } else{ ?>
    <nav class="navbar navbar-default navbar-fixed-top">
        <?php } ?>
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
                <a class="navbar-brand" href="#">chipbug.com</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <?php bootstrap_megamenu_nav(); ?>
                <?php get_search_form() ?>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
