<header class="banner navbar navbar-static-top" role="banner">
  <div class="container hidden-phone">
      <div class="select-head row">
        <div class="span3"><img src="<?= get_stylesheet_directory_uri();?>/assets/img/select-logo.png" alt="Select Property Ltd"/></div>
        <div class="span5 offset4 text-right">
          <div class="main-phone"><?= $_SESSION['company']['head-phone']; ?></div>
          <div class="sub-phone"><?= $_SESSION['company']['head-phone-2']; ?></div>
          <div class="email">E. <a href="mailto:<?= $_SESSION['company']['email']; ?>" onclick="_gaq.push(['_trackEvent', 'Header Email', '<?= $_SESSION['company']['territory']; ?>']);"><?= $_SESSION['company']['email']; ?></a></div>
        </div>
      </div>
  </div>
  <nav class="navbar-inner">
      <?php
        if (has_nav_menu('primary_navigation')) :
          wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav'));
        endif;
      ?>
  </nav>
</header>
