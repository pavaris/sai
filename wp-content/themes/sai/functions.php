<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup()
{
	load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_post_type_support('page', 'excerpt');
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'small', 200 );
	add_image_size( 'productthumb', 500 );
	add_image_size( 'medium', 800 );
	add_image_size( 'large', 1400 );	
	add_image_size( 'full', 1900 );
	global $content_width;
	if ( ! isset( $content_width ) ) $content_width = 640;
	register_nav_menus(
	array( 'main-menu' => __( 'Main Menu', 'blankslate' ) )
	);
}

add_filter( 'body_class', function( $classes ) {
    if ( !wp_is_mobile() ) {
        array_push($classes, 'is_desktop');
    }else{
	    array_push($classes, 'is_mobile');
    }
    return $classes;
} );

add_action( 'wp_enqueue_scripts', 'blankslate_load_scripts' );
function blankslate_load_scripts()
{
	wp_enqueue_script( 'jquery' );
	
	wp_register_script( 'jquery-easing', "https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js");
	wp_enqueue_script("jquery-easing");
	
	wp_register_script( 'masonry', get_template_directory_uri()."/js/masonry.pkgd.min.js");
	wp_enqueue_script("masonry");
	
	wp_register_script( 'isotope', get_template_directory_uri()."/js/isotope.pkgd.min.js");
	wp_enqueue_script("isotope");
	
	wp_register_script( 'packery', get_template_directory_uri()."/js/packery-mode.pkgd.min.js");
	wp_enqueue_script("packery");
	
	wp_register_script( 'imagesloaded', get_template_directory_uri()."/js/imagesloaded.pkgd.min.js");
	wp_enqueue_script("imagesloaded");
	
	wp_register_script( 'cookie', get_template_directory_uri()."/js/js.cookie.js");
	wp_enqueue_script("cookie");
	
	wp_register_script( 'slick', get_template_directory_uri()."/js/slick/slick.js");
	wp_enqueue_script("slick");
	
	wp_enqueue_style( 'jquery-ui-style',"https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css");

	wp_register_script( 'jquery-ui', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js");
	wp_enqueue_script("jquery-ui");
	
	wp_enqueue_style( 'slick-style', get_template_directory_uri()."/js/slick/slick.css");
	
	wp_register_script( 'scripts', get_template_directory_uri()."/js/scripts.js");
	wp_enqueue_script("scripts");
	
	
}

add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script()
{
	if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	}
	add_filter( 'the_title', 'blankslate_title' );
	function blankslate_title( $title ) {
	if ( $title == '' ) {
	return '&rarr;';
	} else {
	return $title;
	}
}

add_filter( 'wp_title', 'blankslate_filter_wp_title' );
function blankslate_filter_wp_title( $title )
{
	return $title . esc_attr( get_bloginfo( 'name' ) );
}

add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init()
{
	register_sidebar( array (
	'name' => __( 'Sidebar Widget Area', 'blankslate' ),
	'id' => 'primary-widget-area',
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => "</li>",
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
	) );
}

add_action('wp_head','pluginname_ajaxurl');
function pluginname_ajaxurl() { ?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var templateurl = '<?php echo get_template_directory_uri(); ?>';
		var homeurl = '<?php echo get_home_url(); ?>';
		var siteurl = '<?php echo site_url(); ?>';
	</script>
<?php
}

function blankslate_custom_pings( $comment )
{
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
	<?php 
}

add_filter( 'get_comments_number', 'blankslate_comments_number' );
function blankslate_comments_number( $count )
{
	if ( !is_admin() ) {
	global $id;
	$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
	return count( $comments_by_type['comment'] );
	} else {
	return $count;
	}
}



add_action('wp_ajax_nopriv_do_ajax', 'ajax_function');
add_action('wp_ajax_do_ajax', 'ajax_function');

function ajax_function(){
     switch($_REQUEST['fn']){
	case 'get_posts':
       $output = get_post_feed(array('post_type' => 'post', 'posts_per_page' => 8, 'paged' => $_REQUEST['paged']),true);
        echo $output;
	   break;
	case 'get_search_posts':
       $output = get_post_feed(array('post_type' => array('post', 'episode'), 'posts_per_page' => 8, 'paged' => $_REQUEST['paged'], 's' => $_REQUEST['searchby']));
        echo $output;
	   break;
	case 'get_podcasts':
       $output = get_podcast_feed(array('post_type' => 'episode', 'posts_per_page' => 8, 'paged' => $_REQUEST['paged'], 'post_status' => 'publish'));
        echo $output;
	   break;
	default:
		$output = 'nothing here';
		echo $output;
	break;
	}
}







function wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => htmlentities(addslashes(get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ))),
        'caption' => $attachment->post_excerpt,
        'description' => htmlentities(addslashes($attachment->post_content)),
        'href' => htmlentities(addslashes(get_permalink( $attachment->ID ))),
        'src' => htmlentities(addslashes($attachment->guid)),
        'title' => htmlentities(addslashes($attachment->post_title))
    );
}

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}