<?php
/**
 * WPBakery Visual Composer shortcodes
 *
 * @package WPBakeryVisualComposer
 *
 */

class WPBakeryShortCode_VC_Wp_Search extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = '';
    extract( shortcode_atts( array(
      'title' => '',
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_search wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Search';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_search') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Meta extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = '';
    extract( shortcode_atts( array(
      'title' => __('Meta'),
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_meta wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Meta';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_meta') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Recentcomments extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $number = $el_class = '';
    extract( shortcode_atts( array(
      'title' => __('Recent Comments'),
      'number' => 5,
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_recentcomments wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Recent_Comments';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_recentcomments') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Calendar extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = '';
    extract( shortcode_atts( array(
      'title' => '',
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_calendar wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Calendar';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_calendar') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Pages extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = $sortby = $exclude = '';
    extract( shortcode_atts( array(
      'title' => __( 'Pages' ),
      'sortby' => 'menu_order',
      'exclude' => null,
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_pages wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Pages';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_pages') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Tagcloud extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = $taxonomy = '';
    extract( shortcode_atts( array(
      'title' => __( 'Tags' ),
      'taxonomy' => 'post_tag',
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_tagcloud wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Tag_Cloud';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_tagcloud') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Custommenu extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = $nav_menu = '';
    extract( shortcode_atts( array(
      'title' => '',
      'nav_menu' => '',
      'el_class' => ''
    ), $atts ) );
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_custommenu wpb_content_element'.$el_class.'">';
    $type = 'WP_Nav_Menu_Widget';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_custommenu') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Text extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $el_class = $text = $filter = '';
    extract( shortcode_atts( array(
      'title' => '',
      'text' => '',
      'filter' => true,
      'el_class' => ''
    ), $atts ) );
    $atts['filter'] = true; //Hack to make sure that <p> added
    
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_text wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Text';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_text') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Posts extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $number = $show_date = $el_class = '';
    extract( shortcode_atts( array(
      'title' => __('Recent Posts'),
      'number' => 5,
      'show_date' => false,
      'el_class' => ''
    ), $atts ) );
    $atts['show_date'] = $show_date;
    
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_posts wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Recent_Posts';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_posts') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Links extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $category = $orderby = $options = $el_class = '';
    extract( shortcode_atts( array(
      'category' => false,
      'orderby' => 'name',
      'options' => '',
      'limit' => -1,
      'el_class' => ''
    ), $atts ) );
    $options = explode(",", $options);    
    if (in_array("images", $options)) $atts['images'] = true;
    if (in_array("name", $options)) $atts['name'] = true;
    if (in_array("description", $options)) $atts['description'] = true;
    if (in_array("rating", $options)) $atts['rating'] = true;
    
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_links wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Links';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_links') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Categories extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $options = $el_class = '';
    extract( shortcode_atts( array(
      'title' => __( 'Categories' ),
      'options' => '',
      'el_class' => ''
    ), $atts ) );
    $options = explode(",", $options);    
    if (in_array("dropdown", $options)) $atts['dropdown'] = true;
    if (in_array("count", $options)) $atts['count'] = true;
    if (in_array("hierarchical", $options)) $atts['hierarchical'] = true;
        
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_categories wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Categories';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_categories') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Archives extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $optioins = $el_class = '';
    extract( shortcode_atts( array(
      'title' => __('Archives'),
      'options' => '',
      'el_class' => ''
    ), $atts ) );
    $options = explode(",", $options);    
    if (in_array("dropdown", $options)) $atts['dropdown'] = true;
    if (in_array("count", $options)) $atts['count'] = true;
    
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_archives wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_Archives';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_archives') . "\n";
  }
}

class WPBakeryShortCode_VC_Wp_Rss extends WPBakeryShortCode {
  protected function content($atts, $content = null) {
    $title = $url = $items = $options = $el_class = '';
    extract( shortcode_atts( array(
      'title' => '',
      'url' => '',
      'items' => 10,
      'options' => '',
      'el_class' => ''
    ), $atts ) );
    if ($url=='') return;
    $atts['title'] = $title;
    $atts['items'] = $items;
    
    $options = explode(",", $options);    
    if (in_array("show_summary", $options)) $atts['show_summary'] = true;
    if (in_array("show_author", $options)) $atts['show_author'] = true;
    if (in_array("show_date", $options)) $atts['show_date'] = true;
    
    $output = '';
    $el_class = $this->getExtraClass($el_class);
    
    $output = '<div class="vc_wp_rss wpb_content_element'.$el_class.'">';
    $type = 'WP_Widget_RSS';
    $args = array();
    
    ob_start();
    the_widget( $type, $atts, $args ); 
    $output .= ob_get_clean();
          
    $output .= '</div>';
    
    return $output . $this->endBlockComment('vc_wp_rss') . "\n";
  }
}

?>