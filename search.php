<?php get_header() ?>
    <div class="index-view">
      <span><a href="<?php echo get_permalink('5') ?>">Index</a></span>
      <span class="active"><a href="<?php echo get_permalink('66') ?>">Preview</a></span>
    </div>
    <?php get_template_part('results-search-term') ?>
<?php if ( have_posts() ) : ?>
    <div class="index-wrapper index-preview-wrapper">
      <div class="index-header">
        <div class="column-artist column active" data-filter=".column-artist"><span><i>Artist</i></span></div>
        <div class="column-author column" data-filter=".column-author"><span><i>Author</i></span></div>
        <div class="column-essay column" data-filter=".column-essay"><span><i>Essay Preview</i></span></div>
        <div class="column-other column" data-filter=".column-topic"><span><i>Topic</i></span></div>
      </div>
      <div class="index-body">

<?php
    while ( have_posts() ) :
      the_post();
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
              <br><br>
              <?php the_excerpt() ?>
            </div>
            <div class="column-topic column">
              <?php the_tags('', '') ?>
            </div>
        </div>
<?php
    endwhile;
  endif;
  wp_reset_postdata();
?>

          </div>
        </div>
<?php get_footer() ?>
</body>
</html>
