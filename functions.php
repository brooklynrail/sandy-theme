<?php

// Alter the ORDER BY statement of WP_query to allow correct pagination
// on a random order of posts.
// To reset normal order_by params, use: remove_all_filters('posts_orderby');
// http://wordpress.stackexchange.com/a/33275
session_start();
add_filter('posts_orderby', 'edit_posts_orderby');
function edit_posts_orderby($orderby_statement) {
    if (strpos($orderby_statement, 'RAND()') !== false) {
      $seed = $_SESSION['seed'];
      if (empty($seed)) {
        $seed = rand();
        $_SESSION['seed'] = $seed;
      }
      $orderby_statement = 'RAND('.$seed.')';
      return $orderby_statement;
    }
}

// Increase number of posts in archive
function sandbox_increase_query( $query ) {
if ( $query->is_archive() && $query->is_main_query() && !is_admin() ) {
    $query->set( 'posts_per_page', -1 );
  }
}
add_action( 'pre_get_posts', 'sandbox_increase_query' );

// Change excerpt read more style
function sandbox_excerpt_more( $more ) {
  return '...';
}
add_filter('excerpt_more', 'sandbox_excerpt_more');

// Add support for Advanced Custom Fields JSON data in JSON-API plugin
add_filter('json_api_encode', 'sandbox_json_api_encode_acf');
function sandbox_json_api_encode_acf($response)
{
  if (isset($response['posts'])) {
    foreach ($response['posts'] as $post) {
      sandbox_json_api_add_acf($post); // Add specs to each post
    }
  }
  else if (isset($response['post'])) {
    sandbox_json_api_add_acf($response['post']); // Add a specs property
  }

  return $response;
}

function sandbox_json_api_add_acf(&$post)
{
  $post->acf = get_fields($post->id);
}

// Disable Wordpress Generator meta tag for security reasons
function sandbox_version_info() {
   return '';
}
add_filter('the_generator', 'sandbox_version_info');

// Remove unnecessary wp_head items
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// Disable Admin Bar
add_filter('show_admin_bar', '__return_false');

// Adds custom menu support
add_theme_support( 'menus' );

// Function to create slug out of text
function sandbox_slugify( $text )
{
  $str = strtolower( trim( $text ) );
  $str = preg_replace( '/[^a-z0-9-]/', '-', $str );
  $str = preg_replace( '/-+/', "-", $str );
  return trim( $str, '-' );
}

// Custom excerpt size
function sandbox_custom_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
  array_pop($excerpt);
  $excerpt = implode(" ",$excerpt).'...';
  } else {
  $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function sandbox_content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
  array_pop($content);
  $content = implode(" ",$content).'...';
  } else {
  $content = implode(" ",$content);
  }
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

// Add Custom Image Sizes
// add_image_size( 'custom-image-size-name', 300, 300, true ); // Custom Image - Name, Width, Height, Hard Crop boolean
add_image_size( 'wide', 400, 1200, false );
add_image_size( 'tall', 1200, 400, false );

// Open external links in new windows
/* function sandbox_autoblank($text) {
$return = str_replace('href=', 'target="_blank" href=', $text);
$return = str_replace('target="_blank" href="echo home_url()', 'echo home_url()', $return);
$return = str_replace('target="_blank" href="#', 'href="#', $return);
$return = str_replace(' target = "_blank">', '>', $return);
return $return;
}
add_filter('the_content', 'sandbox_autoblank');
add_filter('comment_text', 'sandbox_autoblank'); */

// Check for custom Single Post templates by category ID. Format for new template names is single-category[ID#].php (ommiting the brackets)
/*
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));
 */

// REMOVE META BOXES FROM WORDPRESS DASHBOARD FOR ALL USERS
function sandbox_remove_dashboard_widgets(){
  // Globalize the metaboxes array, this holds all the widgets for wp-admin
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);}
add_action('wp_dashboard_setup', 'sandbox_remove_dashboard_widgets' );

//
// Shortcode functions
//

function sandbox_citation_shortcode( $atts, $content = null ) {
  return '<div class="citation">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'citation', 'sandbox_citation_shortcode' );

function sandbox_regular_blockquote_shortcode( $atts, $content = null ) {
  return '<div class="blockquote-regular">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'blocktext', 'sandbox_regular_blockquote_shortcode' );

function sandbox_image_shortcode( $atts, $content = null ) {
  return '<div class="single-image">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'image', 'sandbox_image_shortcode' );

function sandbox_images_2_shortcode( $atts, $content = null ) {
  return '<div class="two-images">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'images_2', 'sandbox_images_2_shortcode' );

// Remove inline style from wp_tag_cloud()
function sandbox_no_inline_style_tag_cloud( $list ) {
  $list = preg_replace('/style=("|\')(.*?)("|\')/','',$list);
  return $list;
}
add_filter ( 'wp_tag_cloud', 'sandbox_no_inline_style_tag_cloud' );

function sandbox_get_posts_count_by_tag($tag_name){
  $tags = get_tags(array ('search' => $tag_name) );
  return $tags[0]->count;
}

?>
