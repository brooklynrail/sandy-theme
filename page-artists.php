<?php
/*
Template Name: Artists Page
*/
?>
<?php get_header() ?>
    <div class="index-view">
      <span class="active"><a href="<?php echo get_permalink('5') ?>">Index</a></span>
      <span><a href="<?php echo get_permalink('66') ?>">Preview</a></span>
    </div>
    <div class="content">
<?php the_post() ?>
      <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
        <div class="index-wrapper index-list-wrapper">
          <div class="index-header">
            <div class="column-artist column active" data-filter=".column-artist"><span><i>Artist</i></span></div>
            <div class="column-author column" data-filter=".column-author"><span><i>Author</i></span></div>
            <div class="column-essay column" data-filter=".column-essay"><span><i>Essay</i></span></div>
          </div>
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
?>
            <div class="index-row">
                <div class="column-artist column active">
                  <a href="<?php the_permalink() ?>" data-essay="true">
                    <?php the_field('artist_name') ?>
                  </a>
                </div>
                <div class="column-author column">
                  <a href="<?php the_permalink() ?>" data-essay="true">
                    <?php the_field('author_name') ?>
                  </a>
                </div>
                <div class="column-essay column">
                  <a href="<?php the_permalink() ?>" data-essay="true">
                    <?php the_title() ?>
                  </a>
                </div>
            </div>
<?php
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
