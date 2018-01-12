<?php

function add_roles_on_plugin_activation() {
	add_role( 'candidate', __('Candidate'), array( 'read' => true, 'candidate' => true ) );
	add_role('recruiter', __('Recruiter'), array('read' => true, 'recruiter' => true) );
}
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

function searchjob_setup() {
	load_theme_textdomain('searchjob');
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'searchjob-featured-image', 2000, 1200, true );
	add_image_size( 'searchjob-thumbnail-avatar', 100, 100, true );
	$GLOBALS['content_width'] = 525;
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'searchjob' ),
		'social' => __( 'Social Links Menu', 'searchjob' ),
	) );
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_editor_style( array( 'assets/css/editor-style.css',searchjob_fonts_url() ) );
}
add_action( 'after_setup_theme', 'searchjob_setup' );

function searchjob_fonts_url() {
	$fonts_url = '';
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'searchjob' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

function searchjob_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'searchjob-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'searchjob_resource_hints', 10, 2 );

function searchjob_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'searchjob' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'searchjob_excerpt_more' );

function searchjob_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'searchjob_javascript_detection', 0 );

function searchjob_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'searchjob_pingback_header' );

function searchjob_scripts() 
{
	wp_enqueue_style( 'searchjob-fonts', searchjob_fonts_url(), array(), null );
	wp_enqueue_style( 'searchjob-style', get_stylesheet_uri() );
	wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/assets/js/script.js', array('jquery'), 1.0 );
	wp_localize_script( 'ajax-script', 'ajax_var', array( 'url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce('ajaxnonce') )); // setting ajaxurl
	wp_localize_script( 'ajax-script', 'lang', array(
		'msg_all_field_required' => __('The all field is require.'),
		'msg_password_confirm_incorrect' => __('Password confirm incorrect.'),
	    'label_edit' => __('Edit'),
	    'label_delete' => __('Delete')
	 ));

	
	wp_enqueue_style( 'bootstrap', get_theme_file_uri( '/assets/css/bootstrap.min.css' ), array(), '3.3.7' );
	wp_enqueue_style( 'bootstrap-theme', get_theme_file_uri( '/assets/css/bootstrap-theme.min.css' ), array(), '3.3.7' );
	wp_enqueue_style( 'jquery-ui', get_theme_file_uri( '/assets/css/jquery-ui.min.css' ), array(), '1.12.1' );
	wp_enqueue_style( 'jquery-ui-structure', get_theme_file_uri( '/assets/css/jquery-ui.structure.min.css' ), array(), '1.12.1' );
	wp_enqueue_style( 'jquery-ui-theme', get_theme_file_uri( '/assets/css/jquery-ui.theme.min.css' ), array(), '1.12.1' );
	wp_enqueue_style( 'datatables', get_theme_file_uri( '/assets/css/jquery.dataTables.css' ), array(), '1.10.16' );
	wp_enqueue_style( 'datatables', get_theme_file_uri( '/assets/css/jquery.dataTables_themeroller.css' ), array(), '1.10.16' );
	wp_enqueue_style( 'datatables', get_theme_file_uri( '/assets/css/dataTables.bootstrap.css' ), array(), '1.10.16' );
	wp_enqueue_style( 'bootstrap-datepicker3', get_theme_file_uri( '/assets/css/bootstrap-datepicker3.css' ), array(), '1.6.4' );
	wp_enqueue_style( 'vector-map', get_theme_file_uri( '/assets/css/jquery-jvectormap-2.0.3.css' ), array(), '2.0.3' );

	wp_enqueue_script( 'bootstrap', get_theme_file_uri( '/assets/js/bootstrap.min.js' ), array(), '4.0', true );
	wp_enqueue_script( 'jquery-ui', get_theme_file_uri( '/assets/js/jquery-ui.min.js' ), array(), '1.12.1', true );
	wp_enqueue_script( 'datatables', get_theme_file_uri( '/assets/js/jquery.dataTables.min.js' ), array(), '1.10.16', true );
	wp_enqueue_script( 'datatables', get_theme_file_uri( '/assets/js/dataTables.bootstrap.min.js' ), array(), '1.10.16', true );
	wp_enqueue_script( 'bootstrap-datepicker3', get_theme_file_uri( '/assets/js/bootstrap-datepicker.min.js' ), array(), '1.6.4', true );
	wp_enqueue_script( 'vector-map', get_theme_file_uri( '/assets/js/jquery-jvectormap-2.0.3.min.js' ), array(), '2.0.3', true );
	wp_enqueue_script( 'vector-map-france', get_theme_file_uri( '/assets/js/maps/jquery-jvectormap-fr_regions-mill.js' ), array(), '2.0.3', true );
	wp_enqueue_script( 'vector-map-vietnam', get_theme_file_uri( '/assets/js/maps/vietnam_map.js' ), array(), '2.0.3', true );
}
add_action( 'init', 'searchjob_scripts' );

function searcjobj_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'searcjobj_post_thumbnail_sizes_attr', 10, 3 );

require get_theme_file_path( '/inc/login-functions.php' );
require get_theme_file_path( '/inc/register-functions.php' );
require get_theme_file_path( '/inc/job-functions.php' );