<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>">
  <label for="s"><?php _e('Search the Select Property website:', 'roots'); ?></label>
  <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s" class="search-query" placeholder="">
  <input type="submit" id="searchsubmit" value="<?php _e('Search', 'roots'); ?>" class="btn blue_button">
</form>