<?php
    include('form_insert.php');
    
    function add_typekit() {
        echo '<script type="text/javascript" src="//use.typekit.net/rhk6igh.js"></script><script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
    }
    add_action('wp_footer', 'add_typekit');
    
    function get_country(){
        if (!isset($country)) {

            $countryapi = '7ce2631969111ddcbfbbf67453338440fd1aed570febfbbcffb5e5a1ec1eae89';

            $responseuri = 'http://api.ipinfodb.com/v3/ip-country/?key='.$countryapi.'&ip='.$_SERVER['REMOTE_ADDR'].'';

            $str_response_xml = @file_get_contents($responseuri);
            $location = filter_var($str_response_xml, FILTER_SANITIZE_STRING);

            $locationarray = str_word_count($location , 1);

            $country = $locationarray[1];

        }

        return $country;
    }
?>
