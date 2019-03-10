<?php
/*
Template Name: Topics Page
*/
?>
<?php get_header() ?>
    <div class="content">
<?php the_post() ?>
      <div id="page-<?php the_ID() ?>" class="topics-page-wrapper">
        <div class="topics">
          <?php
            $tags = get_tags();
            if($tags){
              foreach($tags as $tag) {
                echo '<span class="topic"><a href="' . get_tag_link( $tag->term_id ) . '"' . '>' . $tag->name.'</a> <span class="topic-count">(' . sandbox_get_posts_count_by_tag($tag->slug) . ')</span></span>';
              }
            }
          ?>
        </div>
      </div><!-- .post -->
    </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
