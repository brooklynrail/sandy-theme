<?php
/*
Template Name: Artists Preview Page
*/
?>
<?php get_header() ?>
    <div class="index-view">
      <span><a href="<?php echo get_permalink('5') ?>">Index</a></span>
      <span class="active"><a href="<?php echo get_permalink('66') ?>">Preview</a></span>
    </div>
    <div class="content">
<?php the_post() ?>
      <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
        <div class="index-wrapper index-preview-wrapper">
          <?php get_template_part('results-header'); ?>
          <div class="index-body">

<?php
  $args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'orderby' => 'meta_value',
    'meta_key' => 'artist_name',
    'order' => 'asc'
  );

  remove_all_filters('posts_orderby');
  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) :
      $the_query->the_post();
      get_template_part('results');
    endwhile;
  endif;
  wp_reset_postdata();
?>

          </div>
        </div>
      </div><!-- .post -->
    </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
