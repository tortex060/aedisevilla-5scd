<?php

/**
 * GENERAL FUNCTIONS
 ***********************************/
// Add more functions
//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
include_once(locate_template('templates/functions/scripts.php'));
//include_once(locate_template('templates/functions-breadcrumbs.php'));

// Hide admin bar
add_filter('show_admin_bar', '__return_false');

// Active thumbnails
add_theme_support( 'post-thumbnails' );

// Active menus
register_nav_menus( array(
    'menutop' => 'Menu superior',
    'menumiddle' => 'Menu medio',
    'menufooter' => 'Menu inferior',
));

// Add a filter to remove srcset attribute from generated <img> tag
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );










/**
 * GENERIC FUNCTIONS (TOOLS)
 ***********************************/

// Get current url
function current_url() {
    global $wp;
    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    return $current_url;
}

// Check user role
function is_user_role( $role, $user_id = null ) {
    if (is_numeric($user_id)) $user = get_userdata($user_id);
    else $user = wp_get_current_user();
    if (empty($user)) return false;
    return in_array( $role, (array) $user->roles );
}

// Check if post ID exist
function post_id_exists( $id ) {
  return is_string( get_post_status( $id ) );
}

// Get page by slug
function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
    global $wpdb;
    $page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
    if ( $page )
            return get_page($page, $output);
    return null;
}






/**
 * ATTACHMENT FUNCTIONS (IMAGE & VIDEO)
 ***********************************/

// Remove <p> wrapper from images
function filter_ptags_on_images($content){
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    $content = preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
  	return $content;
}
add_filter('the_content', 'filter_ptags_on_images');

// Add <figure> wrapper to images
function jk_img_caption_shortcode_filter($val, $attr, $content = null){
    extract(shortcode_atts(array(
        'id'      => '',
        'align'   => 'aligncenter',
        'width'   => '',
        'caption' => ''
    ), $attr));
    if ( 1 > (int) $width || empty($caption) ) return $val;
    if ( $id ) $id = esc_attr( $id );
    $content = str_replace('<img', '<img itemprop="contentURL"', $content);
    return '<figure id="'.$id.'" class="wp-caption '.esc_attr($align).'" itemscope itemtype="http://schema.org/ImageObject" style="width: ' . (0 + (int) $width) . 'px">' . do_shortcode( $content ) . '<figcaption id="figcaption_'. $id . '" class="wp-caption-text" itemprop="description">' . $caption . '</figcaption></figure>';
}
add_filter( 'img_caption_shortcode', 'jk_img_caption_shortcode_filter', 10, 3 );

// Add <figure> wrapper to images in wp-editor (adminfront)
function html5_insert_image($html, $id, $caption, $title, $align, $url) {
    if(!$caption){
        $html5 = '<figure id="post-'.$id.'" class="align-img'.$align.'">';
        $html5 .= $html;//'<img src="'.$url.'" alt="'.$title.'"/>';
        $html5 .= "</figure>";
        return $html5;
    }else{
        return $html;
    }
}
add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );

// Add <div> wrapper to videos
function my_embed_oembed_html($html, $url, $attr, $post_id) {
  return '<div class="video-wrap"><div class="video-container">' . $html . '</div></div>';
}
add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

// Revome default <a> wrapper to images
function rkv_imagelink_setup() {
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') update_option('image_default_link_type', 'none');
}
add_action('admin_init', 'rkv_imagelink_setup', 10);

// Add OpenGraph image tags to header
function insert_image_src_rel_in_head() {
  global $post;
  if ( !is_singular()) return;
  if(!has_post_thumbnail( $post->ID )) { 
    $default_image=""; 
    echo '<meta property="og:image" content="' . $default_image . '"/>';
  }else{
    $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
    echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    echo '<meta property="og:image:url" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
  }
  echo "";
}
add_action( 'wp_head', 'insert_image_src_rel_in_head', 5 );






/**
 * TAXONOMY FUNCTIONS
 ***********************************/
// Remove <p> wrapper from categories and tags
remove_filter('term_description','wpautop');






/**
 * USER FUNCTIONS
 ***********************************/

// Add user social links as user meta
if (!function_exists('cb_contact_data')) {  
    function cb_contact_data($contactmethods) {
        unset($contactmethods['aim']);
        unset($contactmethods['yim']);
        unset($contactmethods['jabber']);
        if ( is_admin() == true ) {
            $contactmethods['publicemail'] = 'Public Email';
            $contactmethods['position'] = 'Position'; 
        }
        $contactmethods['twitter'] = 'Twitter (sin @)';
        $contactmethods['googleplus'] = 'Google+ (url entera)';
        $contactmethods['linkedin'] = 'Linkedin (url entera)';
        return $contactmethods;
    }
}
add_filter('user_contactmethods', 'cb_contact_data');

// Hide color option in user admin page
remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');

// Hide other dumb option fin user admin page
function hide_personal_options(){
	echo "\n" . '<script type="text/javascript">
	jQuery(document).ready(function($) {
	    $(\'form#your-profile > h3:first\').hide();
	    $(\'form#your-profile > table:first\').hide();
	    $(\'form#your-profile\').show();
	  
	});
	</script>' . "\n";
}
add_action('admin_head','hide_personal_options');







/*
* LOGIN FUNCTIONS
*********************************************/

// Redirect users after login
function no_admin_init() {      
    if (stripos($_SERVER['REQUEST_URI'],'/wp-admin/') !== false // Look for the presence of /wp-admin/ in the url
        &&
        stripos($_SERVER['REQUEST_URI'],'async-upload.php') == false // Allow calls to async-upload.php
        &&
        stripos($_SERVER['REQUEST_URI'],'admin-ajax.php') == false // Allow calls to admin-ajax.php
        ) {
        if (!current_user_can('manage_options')){ 
          wp_redirect(get_option('home').'?action=login&success=true', 302);
        }
    }
}
add_action('init','no_admin_init',0);

// Redirect users after FAIL login
function no_admin_init_fail($username){
    $referrer = $_SERVER['HTTP_REFERER'];
    if(!empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin')){
        wp_redirect(get_bloginfo('url').'?action=login&success=false'); 
    	exit;
    }
}
add_action('wp_login_failed', 'no_admin_init_fail'); 

// Redirect users after logout
function redirect_after_logout(){
  wp_redirect( home_url() );
  exit();
}
add_action('wp_logout','redirect_after_logout');







?>