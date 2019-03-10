<?php get_header() ?>
    <div class="content">
<?php the_post() ?>
      <div id="page-<?php the_ID() ?>" <?php post_class() ?>>
        <div class="page-entry-content entry-content">
          <h4 class="author">
            <?php the_field('essay_title') ?><br>
            <?php if (get_field('author')): ?>
              by <?php the_field('author') ?>
            <?php endif ?>
          </h4>
<?php the_content() ?>
          </div>
        </div>
      </div><!-- .post -->
    </div><!-- .content -->
<?php get_footer() ?>
</body>
</html>
