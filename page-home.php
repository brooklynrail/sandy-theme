<?php
/*
Template Name: Home Page
*/
?>
<?php get_header() ?>
    <div class="content">
<?php the_post() ?>
      <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
        <div class="brick-wrapper">

<?php
  $paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

  $args = array(
    'post_type' => 'post',
    'showposts' => 15,
    'cat' => 3,
    'paged' => $paged,
    'orderby' => 'rand'
  );


  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ):
    while ( $the_query->have_posts() ):
      $the_query->the_post();

      // Image vars
      $image = get_field('image');

      $low_prob    = rand(1, 6) == 1 ? true : false;
      $medium_prob = rand(1, 3) == 1 ? true : false;
      $high_prob   = rand(1, 2) == 1 ? true : false;

      if($high_prob){
        if($medium_prob){
          $size = 'wide';
        } else {
          $size = 'tall';
        }
      } else {
        if($low_prob){
          $size = 'large';
        } else {
          $size = 'medium';
        }
      }
      // $size_high = 'large';
      $image_at_size = $image['sizes'][ $size ];
      $image_at_size_width  = $image['sizes'][ $size . '-width' ];
      $image_at_size_height = $image['sizes'][ $size . '-height' ];

      $image_at_high = $image['sizes'][ $size_high ];
?>

          <div class="brick" style="max-width: <?php echo $image_at_size_width ?>px;">
            <a href="<?php the_permalink() ?>" data-essay="true">
              <img src="<?php echo $image_at_size; ?>" width="<?php echo $image_at_size_width ?>" height="<?php echo $image_at_size_height ?>">
              <div class="brick-info">
                <div class="serif"><?php the_field('artist_name') ?></div>
                <div class="serif italic"><?php the_title(); ?></div>
                <div class="serif">by <?php the_field('author_name'); ?></div>
              </div>
            </a>
          </div>
<?php
    endwhile;
?>
        </div>
<?php
  endif;
  echo '<div class="next-post-link visuallyhidden">';
  next_posts_link( 'Older Entries', $the_query->max_num_pages );
  echo '</div>';
  wp_reset_postdata();
?>

      </div><!-- .post -->
    </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
