<?php
require_once('lib/bootstrap_walker.php');
require_once('lib/yamm-nav-walker.php');

// Bootstrap navigation
function bootstrap_nav(){
	wp_nav_menu( array(
        'theme_location'    => 'header-menu',
        'depth'             => 2,
        'container'         => 'false',
        'menu_class'        => 'nav navbar-nav',
        'fallback_cb'       => 'bootstrap_walker::fallback',
        'walker'            => new bootstrap_walker())
    );
}

function bootstrap_megamenu_nav()
{
	wp_nav_menu( array(
        'theme_location'    => 'header-menu',
        'depth'             => 4,
        'container'         => 'div',
        'container_class'   => 'collapse navbar-collapse',
        'container_id'      => 'bootstrap-navbar-collapse-1',
        'menu_class'        => 'nav navbar-nav yamm',
        'fallback_cb'       => 'Yamm_Nav_Walker_menu_fallback',
        'walker'            => new Yamm_Nav_Walker())
    );
}

add_action( 'init', 'register_header_menu' );
add_action( 'wp_enqueue_scripts', 'register_js' );
add_action( 'wp_enqueue_scripts', 'register_css' );

function register_header_menu() {
  register_nav_menu('header-menu',__( 'Top Bar Menu' ));
}

function register_js() {
    wp_enqueue_script('bootstrap-3.3.7-js','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',array('jquery'),'',true);
    wp_enqueue_script( 'smooth_scroll', get_template_directory_uri() . '/js/smoothscroll.js', array( 'jquery' ), '',  true );
}

function register_css() {
    wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,700', false );
    wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(),'', 'all' );
    wp_enqueue_style( 'bootstrap-theme', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css' , array('bootstrap-css'),'','all');
    wp_enqueue_style('yamm', get_template_directory_uri() . '/css/yamm.css', array('bootstrap-theme'), '', 'all');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css','bootstrap-theme');
}

if ( function_exists('register_sidebar') )
  register_sidebar(array(
      'id' => 'sidebar-widgets',
    'name' => 'sidebar widgets',
    'before_widget' => '<div class = "widgetizedArea">',
    'after_widget' => '</div>',
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
  )
);

function mytheme_comment($comment, $args, $depth) {
    if ( 'div' === $args['style'] ) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    }
    ?>
    <<?php echo $tag ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
            <?php endif; ?>
            <div class="comment-author vcard">           
                <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>' ), get_comment_author_link() ); ?>
            </div>
            <?php if ( $comment->comment_approved == '0' ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
            <br />
            <?php endif; ?>

            <div class="comment-meta commentmetadata">
                <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
                </a>
                <?php edit_comment_link( __( '(Edit)' ), '  ', '' );
        ?>
            </div>

            <?php comment_text(); ?>

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>
            <?php if ( 'div' != $args['style'] ) : ?>
        </div>
        <?php endif; ?>
        <?php
    }
