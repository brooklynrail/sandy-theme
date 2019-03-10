<?php get_header() ?>
    <div class="index-view">
      <span><a href="<?php echo get_permalink('5') ?>">Index</a></span>
      <span class="active"><a href="<?php echo get_permalink('66') ?>">Preview</a></span>
    </div>
    <?php get_template_part('results-search-term') ?>
    <div class="index-wrapper index-preview-wrapper">
      <?php get_template_part('results-header'); ?>
      <div class="index-body">

<?php
  if ( have_posts() ) :
    while ( have_posts() ) :
      the_post();
      get_template_part('results');
    endwhile;
  endif;
  wp_reset_postdata();
?>

          </div>
        </div>
<?php get_footer() ?>
</body>
</html>
