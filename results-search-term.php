<h2 class="search-term">
<?php if ( have_posts() ) : ?>
  <?php if(is_tag()): ?>
    <?php echo ucwords(single_tag_title('', false)) ?>
  <?php else: ?>
    <?php echo ucwords(get_search_query()) ?>
  <?php endif; ?>
  <span class="topic-count">(<?php echo $wp_query->found_posts; ?>)</span>
<?php else : ?>
  No results, trying searching for something else.
<?php endif; ?>
</h2>
