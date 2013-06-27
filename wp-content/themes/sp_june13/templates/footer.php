<footer class="content-info" role="contentinfo">
  <div class="container">
      <div class="row">
          <div class="span8">
            <?php dynamic_sidebar('sidebar-footer'); ?>
          </div>
          <div class="span4">
            <?php dynamic_sidebar('sidebar-footer-1'); ?>
          </div>
      </div>
      <div class="row">
          <div class="span12">
              <div class="base">
                <span class="territory">&copy; <?= date('Y'); ?>. <?php bloginfo('name'); ?> <?= $_SESSION['company']['territory']; ?>&nbsp;|</span>
                <span class="address"><?= $_SESSION['company']['address']; ?></span>&nbsp;|
                <span class="tel"><?= $_SESSION['company']['phone']; ?></span>&nbsp;|
                <span class="email"><a class="email" href="mailto:<?= $_SESSION['company']['email']; ?>"><?= $_SESSION['company']['email']; ?></a></span>
              </div>    
          </div>
      </div>
      <div class="row">
          <div id="baseshadow" class="span12">&nbsp;</div>
      </div>
  </div>
</footer>

<?php wp_footer(); ?>
