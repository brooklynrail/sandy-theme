<?php get_header() ?>
    <a class="close-button" href="<?php echo home_url() ?>"></a>
    <div class="content-padding">
      <h4 class="essay-home-title" id="site-title"><span><a href="<?php bloginfo('url') ?>/" title="<?php echo esc_html( bloginfo('name'), 1 ) ?>" rel="home"><?php bloginfo('name') ?></a></span></h4>
      <div class="essay-info">
        <h2 class="artist"><?php the_field('artist_name') ?></h2>
        <h2 class="essay-title"><?php the_title() ?></h2>
      </div>
    </div>
    <div class="content">
<?php the_post() ?>
      <div id="post-<?php the_ID() ?>" <?php post_class() ?>>
        <div class="entry-content">
          <h4 class="author">by <?php the_field('author_name') ?></h4>
<?php the_content() ?>
        </div>
      </div><!-- .post -->
      <div class="topics-wrapper">
        <div class="topics-title medium sans">Topics</div>
        <div class="topics">
          <?php the_tags(''); ?>
        </div>
      </div>
    </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
