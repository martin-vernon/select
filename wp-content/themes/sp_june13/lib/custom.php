<?php
    include('includes/tgm_plugin_activation.php');
    include('includes/form_insert.php');
    
    // add Typekit font for Myriad Pro
    function add_typekit() {
        echo '<script type="text/javascript" src="//use.typekit.net/rhk6igh.js"></script><script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
    }
    add_action('wp_head', 'add_typekit');
    
    // remove menu walker filter for UberMenu plugin
    remove_filter('nav_menu_css_class', 'roots_nav_menu_css_class', 10, 2);
    
    // add Font Awesome for extra font icons 
    function add_font_awesome() {
        wp_register_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css');
        wp_enqueue_style('font-awesome');
    }
    add_action('wp_head', 'add_font_awesome');
    
    // set additional widget areas for theme
    function set_select_sidebars(){
        register_sidebar(array(
            'name'          => __('Footer Right', 'roots'),
            'id'            => 'sidebar-footer-1',
            'before_widget' => '<section class="widget %1$s %2$s"><div class="widget-inner">',
            'after_widget'  => '</div></section>',
            'before_title'  => '<h3>',
            'after_title'   => '</h3>',
        ));
    }
    add_action('widgets_init', 'set_select_sidebars');
    
    // set Site contact details, switched per territory, using company Session variable to be used anywhere on site.
    function set_address() {
        session_start();
        
        switch ( site_url() ) {
            case 'http://www.selectproperty.ae':
                $_SESSION['company'] = array(
                    'territory'    => 'UAE',
                    'address'      => 'Office 803, Concord Tower, Tecom Dubai Media City, Dubai, United Arab Emirates.',
                    'email'        => 'info@selectproperty.ae',
                    'phone'        => '+971 44462756',
                    'head-phone'   => 'DXB: +971 44462756',
                    'head-phone-2' => 'UK: +44 (0)161 322 2222'
                );
                break;
            default:
                $_SESSION['company'] = array(
                    'territory'    => 'UK',
                    'address'      => 'The Box, Brooke Court, Lower Meadow Road, Handforth, Wilmslow, Cheshire, SK9 3ND. United Kingdom.',
                    'email'        => 'info@selectproperty.com',
                    'phone'        => '+44(0) 161 322 2222',
                    'head-phone'   => 'UK: +44 (0)161 322 2222',
                    'head-phone-2' => 'DXB: +971 44462756'
                );
        }
    }
    add_action('init', 'set_address');
    
    function get_select_social($atts,$content){
        return '<div id="social" class="clearfix">
            <div class="social_title">Find and Follow us on</div>
            <a class="social twitter" href="https://twitter.com/OSelectProperty" title="Select Property on Twitter"></a>
            <a class="social facebook" href="https://www.facebook.com/selectpropertyltd" title="Select Property on Facebook"></a>
            <!--<a class="social vimeo" href="vimeo" title="Select Property on Vimeo"></a>-->
            <a class="social flickr" href="http://www.flickr.com/photos/selectproperty/" title="Select Property on Flickr"></a>
            <a class="social googleplus" href="https://plus.google.com/113680179819262532447" title="Select Property on Google Plus"></a>
        </div>';
    }
    add_shortcode('select_social', 'get_select_social');
?>
