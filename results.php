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
      <a class="column-essay-post-link" href="<?php the_permalink() ?>" data-essay="true">
        <?php the_title() ?>
      </a>
      <?php the_excerpt() ?>
    </div>
    <div class="column-topic column">
      <?php the_tags('', '') ?>
    </div>
</div>
