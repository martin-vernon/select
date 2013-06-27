<?php
function draw_contact_form( $atts, $content = null ){    
    global $site;
    
    extract( shortcode_atts( array(
        'class'    => '',
        'title'    => 'Request full investment details',
        'subtitle' => 'Fill out the form below.',
        'action'   => admin_url('admin-ajax.php'),
        'method'   => 'post',
        'thanks'   => site_url().'/thank-you',
        'submit'   => 'Send me details',
        'small'    => '<em><strong>Note:</strong> Fields marked with <span class="required">*</span> are required.</em>',
        'dev'      => '',
        'source'   => 'Website',
        'modal_box' => "1",
        'emailtemp' => 'select-email-template-v1',
        'comment'  => "0",
        'cta_download' => "0"
    ), $atts ) );
    
    wp_register_style( 
            'sp_contact_form', 
            get_stylesheet_directory_uri() .'/assets/css/contact_form.css',
            array(), '1.0'
    );

    wp_register_script(
            'jquery_simple_modal',
            get_template_directory_uri() .'/assets/javascript/jquery.simplemodal.js',
            array('jquery')
    );

    wp_register_script(
            'sp_contact_mar13',
            get_template_directory_uri() .'/assets/javascript/contact_may13.js',
            array('jquery')
    );
    
    wp_deregister_style('js_composer_front');
    wp_deregister_style('js_composer_custom_css');
    
    wp_enqueue_style('sp_contact_form');
    wp_enqueue_script('jquery_simple_modal');
    wp_enqueue_script('sp_contact_mar13');
    
    $commentHTML = ($comment != "0") ? '<p class="textArea"><label for="comment">Message</label><textarea name="comment" type="text"></textarea></p>' : '';
    
    $title    = ($title != "")    ? '<h2>'.$title.'</h2>'  : '';
    $subtitle = ($subtitle != "") ? '<p>'.$subtitle.'</p>' : '';
    
    $modalID = 'modal_'.mt_rand(100000, 999999);
    
    $output = '<div class="contact_form '.$class.'">
                    
                    <div class="ajax-console-process"></div>'.
                    
                    $title.                    
                    $subtitle.

                    '<form action="'.$action.'" method="'.$method.'" id="signup-form">
                        
                        <div class="alert"><a class="close" data-dismiss="alert">x</a></div>
                        
                        <p class="first"><label for="contact-name" accesskey="N"><span class="required">*</span> First Name:</label>
                        <input type="text" name="contact-name" id="contact-name" class="name"></p>

                        <p><label for="contact-name" accesskey="S"><span class="required">*</span> Surname:</label>
                        <input type="text" name="contact-surname" id="contact-surname" class="surname"></p>

                        <p><label for="contact-email" accesskey="E"><span class="required">*</span> Email Address:</label>
                        <input type="email" name="contact-email" id="contact-email" class="email"></p>

                        <p class="last"><label for="contact-phone" accesskey="P"><span class="required">*</span> Phone Number:</label>
                        <input type="text" name="contact-phone" id="contact-phone" class="phone"></p>'.
                        
                        $commentHTML .

                       '<input type="hidden" name="source" id="contact-leadsource" class="source" value="'.$source.'"/>'.
                        $ppc_data .
                       '<input type="hidden" name="page" id="contact-tracpage" class="tracpage" value="'.get_permalink().'"/>
                        <input type="hidden" name="action" id="contact-function" class="action" value="contact_us"/>                            
                        <input type="hidden" name="development" id="contact-development" class="development" value="'.$dev.'"/>
                        <input type="hidden" name="modal" id="contact-modal" class="modal" value="'.$modal_box.'"/>
                        <input type="hidden" name="modalID" id="contact-modalid" class="modalid" value="'.$modalID.'"/>
                        <input type="hidden" name="emailtemp" id="contact-emailtemp" class="emailtemp" value="'.$emailtemp.'"/>
                        <input type="hidden" name="thanks" id="contact-thanks" class="thanks" value="'.$thanks.'"/>
                            
                        <div class="header-cta">
                            <input type="submit" class="button_red" name="submit" id="regSubmit" value="'.$submit.'">
                            <p class="small">'.$small.'</p>
                        </div> <!-- end header-cta -->
                        <div style="clear:both;"></div>
                    </form>'.
                    $content.
            '</div>';
    
    if($modal_box == "1"){
        $output .= '<!-- modal content -->
                    <div id="osx-modal-content">
                            <div id="osx-modal-title">Thank you for Contacting '.$site['name'].'</div>
                            <div class="close"><a href="#" class="simplemodal-close">x</a></div>
                            <div id="osx-modal-data">
                                <div id="choices">
                                    <h2>How would you like to be contacted?</h2>
                                    <p>Please let us know how you would like to be contacted.</p>
                                    <div class="buttons" style="display: block;">
                                        <a class="phone" href="/contact-us/phone-me" rel="call-me"><span class="small">Call me within the next</span><span class="larger">30 MINUTES</span></a>
                                        <a class="arrange" href="/contact-us/arrange-time" rel="arrange-time"><span class="small">Arrange a suitable</span><span class="larger">time and date</span></a>
                                        <a class="email" href="/contact-us/email-me" rel="email-me"><span class="small">Send me an</span><span class="larger">email</span></a>
                                        <div style="clear: both; display: block;"></div>
                                    </div>
                                </div>
                                <div id="call-me">
                                    '.callMe( $action, $method ).'
                                </div>
                                <div id="arrange-time">
                                    '.arrangeTime( $action, $method ).'
                                </div>
                                <div id="email-me">
                                    '.emailMe( $action, $method ).'
                                </div>
                                <div id="thanks-new">
                                    <h2>Thank You for contacting '.$site['name'].'</h2>
                                    <p>The information you requested will be sent to you shortly and an expert property advisor will be in touch to discuss your requirements. It is our aim to contact you as soon as possible however we are receiving an extremely high number of enquiries so we urge you to contact us directly if you would like to speak to an advisor straight away.</p>
                                    <p class="thanks">In the meantime please continue to browse our website by clicking <a href="#" class="simplemodal-close" title="Close Contact form">here.</a></p>
                                </div>
                                <div id="thanksFooter">
                                    Tel: '.$site['tel'].' | Email: <a href="mailto:'.$site['email'].'" title="Email Us">'.$site['email'].'</a>
                                    <img src="'.get_template_directory_uri().$site['logo'].'" alt="'.$site['name'].'">
                                </div>
                            </div>
                    </div>';
    }else{
        if( $cta_download == "1" ){
            $output .= '<!-- modal content -->
                   <div id="'.$modalID.'" class="basic-modal-content">
                        <div id="thanks-new">
                            <h2>Thank You for contacting '.$site['name'].'</h2>
                            <p>Your email with the link to your requested document will be with your shotly.</p>
                            <p class="thanks">In the meantime please continue to browse our website by clicking <a href="#" class="simplemodal-close" title="Close Contact form">here.</a></p>
                        </div>
                        <div id="thanksFooter">
                            Tel: '.$site['email'].' | Email: <a href="mailto:'.$site['email'].'" title="Email Us">'.$site['email'].'</a>
                            <img src="'.get_template_directory_uri().$site['logo'].'" alt="'.$site['name'].'">
                        </div>
                   </div>';
        }else{
            $output .= '<!-- modal content -->
                   <div id="'.$modalID.'" class="basic-modal-content">
                        <div id="thanks-new">
                            <h2>Thank You for contacting '.$site['name'].'</h2>
                            <p>The information you requested will be sent to you shortly and an expert property advisor will be in touch to discuss your requirements. It is our aim to contact you as soon as possible however we are receiving an extremely high number of enquiries so we urge you to contact us directly if you would like to speak to an advisor straight away.</p>
                            <p class="thanks">In the meantime please continue to browse our website by clicking <a href="'.site_url().'" class="simplemodal-close" title="Close Contact form">here.</a></p>
                        </div>
                        <div id="thanksFooter">
                            Tel: '.$site['tel'].' | Email: <a href="mailto:'.$site['email'].'" title="Email Us">'.$site['email'].'</a>
                            <img src="'.get_template_directory_uri().$site['logo'].'" alt="'.$site['name'].'">
                        </div>
                   </div>';
        }
    }
    
    return $output;
}

add_shortcode( 'draw_sp_form' , 'draw_contact_form' );

function callMe( $action, $method ) {
    $html = '<h2>An advisor will call you within the next 30 minutes.</h2>
            <p><img src="'.get_stylesheet_directory_uri().'/assets/img/ajax-loader-grey.gif" /></p>
            <p>Please wait whilst we process your request.</p>
            <div id="call-now-form" class="contact-form"><form action="'.$action.'" method="'.$method.'">
                <input type="hidden" name="action" value="call_now" />
            </form></div>';
    
    return $html;
}

function arrangeTime( $action, $method ) {
    $html = '<div class="contact_form left">
                <div class="ajax-console-process"></div>
                <h2>Arrange a time convenient for you</h2>
                <p>An advisor will call you on your designated date and time below:</p>
                <form action="'.$action.'" method="'.$method.'">
                    <div class="alert"><a class="close" data-dismiss="alert">x</a></div>
                    <div class="datepicker left">
                        <select type="text" class="date_day" name="date_day"><option value="00">Day</option><option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>
                        <select type="text" class="date_month" name="date_month"><option value="00">Month</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select>
                        <select type="text" class="date_year" name="date_year"><option value="0000">Year</option><option value="'.date('Y').'">'.date('Y').'</option></select>
                    </div>
                    <div class="checkbox right">
                        <div><input type="radio" name="time" value="Morning"><label>Morning (8AM - 12PM)</label></div>
                        <div><input type="radio" name="time" value="Afternoon"><label>Afternoon (12PM - 5PM)</label></div>
                        <div><input type="radio" name="time" value="Evening"><label>Evening (5PM - 8PM)</label></div>
                        <div class="clearfix">NOTE: All times shown are GMT.</div>
                    </div>
                    <div class="clearfix">
                        <input type="hidden" name="action" value="arrange_time" />
                    </div>
                    <div class="header-cta">
                        <input class="button_red" type="submit" rel="2" value="CALL ME" />
                        <p class="small"><strong>Note:</strong> Fields marked with a <span class="req">*</span> are required.</p>
                    </div>
                </form>
            </div>
            <div class="buttons right" style="display: block;">
                <p>Or if you prefer...</p>
                <a class="phone" href="/contact-us/phone-me" rel="call-me"><span class="small">Call me within the next</span><span class="larger">30 MINUTES</span></a>
                <a class="email" href="/contact-us/email-me" rel="email-me"><span class="small">Send me an</span><span class="larger">email</span></a>
            </div>
            <div class="clearfix"></div>';
    
    return $html;
}

function emailMe( $action, $method ) {
$html = '<div class="contact_form left">
            <div class="ajax-console-process"></div>
            <h2>Send me an Email.</h2>
            <p>An advisor will send you an e-mail based on your requirements below:</p>
            <form action="'.$action.'" method="'.$method.'">
                <div class="alert"><a class="close" data-dismiss="alert">x</a></div>
                <div>
                    <label>When are you looking to invest?</label>
                    <select name="email_when" type="text">
                        <option value="This Month"> This Month </option>
                        <option value="Next Month"> Next Month </option>
                        <option value="Within 1 Year"> Within 1 year </option>
                        <option value="Next Year"> Next Year </option>
                    </select>
                </div>
                <div>
                    <label>Have you invested before?</label>
                    <select name="email_have" type="text">
                        <option value="Yes"> Yes </option>
                        <option value="No"> No </option>
                    </select>
                </div>
                <div>
                    <label>If YES please give details:</label>
                    <textarea name="email_invested" type="text"></textarea>
                    <div class="clearfix"></div>
                </div>	
                <div class="multi">
                    <label style="line-height:30px;margin-right:10px;">Budget</label>
                    <input name="email_budget" class="left" type="text" style="width:130px;height:14px;margin-top:4px;font-weight:400;">
                    <label style="width:60px;float:left;margin:0 0 0 15px;height: 34px;line-height: 30px;">Currency</label>
                    <select name="email_currency" type="text">
                        <option value="GBP"> GBP </option>
                        <option value="HKD"> HKD </option>
                        <option value="SPD"> SPD </option>
                        <option value="USD"> USD </option>
                    </select>
                </div>
                <div>
                    <label>Would you require finance?</label>
                    <select name="email_finance" type="text">
                        <option value="Yes"> Yes </option>
                        <option value="No"> No </option>
                    </select>
                </div>
                <div>
                    <label>Additional Requirements:</label>
                    <textarea name="email_additional" type="text"></textarea>
                </div>
                <div class="clearfix">
                    <input type="hidden" name="action" value="email_me" />
                </div>
                <div class="header-cta">
                    <input class="button_red" type="submit" rel="2" value="EMAIL ME DETAILS" />
                    <p class="small"><strong>Note:</strong> Fields marked with a <span class="req">*</span> are required.</p>
                </div>
            </form>
         </div>
         <div class="buttons right">
             <p>Or if you prefer...</p>
             <a class="phone" href="/contact-us/phone-me" rel="call-me"><span class="small">Call me within the next</span><span class="larger">30 MINUTES</span></a>
             <a class="arrange" href="/contact-us/arrange-time" rel="arrange-time"><span class="small">Arrange a suitable</span><span class="larger">time and date</span></a>
         </div>
         <div class="clearfix"></div>';
    
    return $html;
}


add_action("wp_ajax_nopriv_contact_us", "my_user_contact_us");
add_action("wp_ajax_nopriv_call_now", "my_user_call_now");
add_action("wp_ajax_nopriv_arrange_time", "my_user_arrange_time");
add_action("wp_ajax_nopriv_email_me", "my_user_email_me");
add_action("wp_ajax_nopriv_process_lead", "my_user_process_lead");

add_action("wp_ajax_contact_us", "my_user_contact_us");
add_action("wp_ajax_call_now", "my_user_call_now");
add_action("wp_ajax_arrange_time", "my_user_arrange_time");
add_action("wp_ajax_email_me", "my_user_email_me");
add_action("wp_ajax_process_lead", "my_user_process_lead");

function my_user_contact_us( $return = false ) {
    global $wpdb;
    
    $name      = $_REQUEST['contact-name'];
    $surname   = $_REQUEST['contact-surname'];
    $email     = $_REQUEST['contact-email'];
    $phone     = $_REQUEST['contact-phone'];
    $page      = $_REQUEST['page'];
    $country   = $_REQUEST['country'];
    $dev       = $_REQUEST['development'];
    $source    = $_REQUEST['source'];
    $modal     = $_REQUEST['modal'];
    $modalID   = $_REQUEST['modalID'];
    $emailTemp = $_REQUEST['emailtemp'];

    if( (trim($name) == '') || (trim($name) == 'First Name: Required.') ) {
        $result['error']['contact-name'] = 'First Name: Required.';
    }

    if( (trim($surname) == '') || (trim($surname) == 'Surname: Required.') ) {
        $result['error']['contact-surname'] = 'Surname: Required.';
    }

    if( (trim($email) == '') || (trim($email) == 'Email: Required.') || (trim($email) == 'Email: Invalid.') ) {
        $result['error']['contact-email'] = 'Email: Required.';
    } elseif(!isEmail($email)) {
        $result['error']['contact-email'] = 'Email: Invalid.';
    }

    if( (trim($phone) == '') || (trim($phone) == 'Phone Number: Required.') ) {
        $result['error']['contact-phone'] = 'Phone Number: Required.';
    }
    
    if(!$result['error']){
        $data = $_REQUEST;
        if(!initialInsert( $data )) 
            $result['error']['db'] = 'DB Error: '.$wpdb->last_error;
        
        if($modal == "0"){
            $initalData = get_data( $dbid );
            $pbdata = set_propBase_data( $initalData );
            if(!sp_do_propBase( $pbdata ))
                $result['error']['propBase'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
            if(!sendleadmail( $pbdata )) 
                $result['error']['email'] = 'Lead email not sent';
        }
        
        if(!sp_sendmail( $data )) 
            $result['error']['email'] = 'Welcome email not sent';

    }
    
    if($result['error']){
        $result['type'] = 'error';
    } else {   
        $result['type']    = 'success';
        $result['ga_action'] = $dev.'-Contact';
        $result['ga_label']    = 'Contact-Complete';
    }
    $result['modal'] = $modal;
    $result['modalID'] = $modalID;
    
    if( $return ) {
        return json_encode( $result );
    } else {
        echo json_encode( $result );
        die();
    }
}

function my_user_call_now( $return = false ) {
    if(!$result['error']){
        //get temp db info
        $initalData = get_data( $dbid );
        if( $initalData === false){
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry. Couldnt get data from DB';
        } else {
            //set up PB data to send
            $data = set_propBase_data( $initalData );
            //add aditional data for this screen into PB for idetification.
            date_default_timezone_set( 'Europe/London' );
            $callby = time() + (60 * 30);
            $data['Enquiry_Nature__pc'] = 'Phone';
            $data['Sup__c'] = date('H:i d/m/Y', $callby);
            
            //do PB insert using data from step 1
            //send welcome email
            //send lead email
            if(!sp_do_propBase( $data ))
                $result['error']['propBase'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
            if(!sp_sendmail( $data ))
                $result['error']['email'] = 'Client email not sent.';
            if(!sendleadmail( $data ))
                $result['error']['email'] = 'Lead email not sent.';
        }
    }
    
    if($result['error']){
        $result['type']    = 'error';
    } else {   
        $result['type'] = 'success';
        $result['ga_action'] = $data['Preferred_Development__c'].'-Contact';
        $result['ga_label']    = 'Call-Me-Now';
        //delete data from step 1 from temp table
        if(!del_data())
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
    }
    
    if( $return ) {
        return json_encode( $result );
    } else {
        echo json_encode( $result );
        die();
    }
}

function my_user_arrange_time( $return = false ) {
    $day   = $_REQUEST['date_day'];
    $month = $_REQUEST['date_month'];
    $year  = $_REQUEST['date_year'];
    $time  = $_REQUEST['time'];

    if($day == '00'){
        $result['error']['day'] = 'You must select a day.';
    }

    if($month == '00'){
        $result['error']['month'] = 'You must select a month.';
    }

    if($year == '0000'){
        $result['error']['year'] = 'You must select a year.';
    }

    if(!$result['error']){
        $today = strtotime(date('Y-m-d'));
        $chosen = strtotime(date($year.'-'.$month.'-'.$day));

        if($chosen < $today){
            $result['error']['date'] = 'You have chosen <strong>'.$day.'/'.$month.'/'.$year.'</strong>. Please pick an alternate date, either today or in the future.';
        }
    }

    if(trim($time) == ''){
        $result['error']['time'] = 'Please select a time of day for us to contact you on your selected date.';
    }

    if(!$result['error']){
        //get temp db info
        $initalData = get_data();
        if( $initalData === false){
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry - DBError1';
        } else {
            //set up PB data to send
            $data = set_propBase_data( $initalData );
            //add aditional data for this screen into PB for idetification.
            $data['Enquiry_Nature__pc'] = 'Scheduled';
            $data['Sup__c'] = $day.'/'.$month.'/'.$year.' - '.$time;

            //do PB insert using data from step 1
            //send welcome email
            //send lead email
            if(!sp_do_propBase( $data ))
                $result['error']['propBase'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry - PBError1';
            if(!sp_sendmail( $data ))
                $result['error']['email'] = 'Client email not sent.';
            if(!sendleadmail( $data ))
                $result['error']['email'] = 'Lead email not sent.';
        }
    }    
    
    if($result['error']){
        $result['type']    = 'error';
    } else {   
        $result['type'] = 'success';
        $result['ga_action'] = $data['Preferred_Development__c'].'-Contact';
        $result['ga_label']    = 'Arrange-A-Date';
        //delete data from step 1 from temp table
        if(!del_data())
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
    }
    
    if( $return ) {
        return json_encode( $result );
    } else {
        echo json_encode( $result );
        die();
    }
}

function my_user_email_me( $return = false ) {
    //email me
    $when        = $_REQUEST['email_when'];
    $have        = $_REQUEST['email_have'];
    $haveDetails = $_REQUEST['email_invested'];
    $budget      = $_REQUEST['email_budget'];
    $currency    = $_REQUEST['email_currency'];
    $finance     = $_REQUEST['email_finance'];
    $additional  = $_REQUEST['email_additional'];

    if(trim($budget) == ''){
        $result['error']['email_budget'] = 'Please specify your budget within the currency that you operate in.';
    }

    if(trim($have) == 'Yes' && trim($haveDetails) == ''){
        $result['error']['email_invested'] = 'You have specified that you have invested before, please give details of this investment.';
    }

    if(!$result['error']) {
        //get temp db info
        $initalData = get_data();
        if( $initalData === false){
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
        } else {
            //set up PB data to send
            $data = set_propBase_data( $initalData );
            //add aditional data for this screen into PB for idetification.
            $data['Enquiry_Nature__pc'] = 'Email';
            $data['Sup__c'] = 'EMAIL DETAILS'."\n".
                              'When are they looking to invest - '.$when."\n".
                              'Have they invested before - '.$have."\n".
                              'if YES, details of investment - '.$haveDetails."\n".
                              'Budget - '.$budget.' '.$currency."\n".
                              'is finance required - '.$finance."\n".
                              'Other requirements - '.$additional."\n";

            //do PB insert using data from step 1
            //send welcome email
            //send lead email
            if(!sp_do_propBase( $data ))
                $result['error']['propBase'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
            if(!sp_sendmail( $data ))
                $result['error']['email'] = 'Client email not sent.';
            if(!sendleadmail( $data ))
                $result['error']['email'] = 'Lead email not sent.';
        }
    }
    
    if($result['error']){
        $result['type'] = 'error';
    } else {   
        $result['type'] = 'success';
        $result['ga_action'] = $data['Preferred_Development__c'].'-Contact';
        $result['ga_label']    = 'Send-Me-Email';
        //delete data from step 1 from temp table
        if(!del_data())
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
    }
    
    if( $return ) {
        return json_encode( $result );
    } else {
        echo json_encode( $result );
        die();
    }
}

function my_user_process_lead() {
    //get temp db info
    session_start();
    if(isset( $_SESSION['contact_id'] ) ){
        $initalData = get_data();
        if( $initalData === false){
            $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
        } else {
            //set up PB data to send
            $data = set_propBase_data( $initalData );
            
            if(!sp_do_propBase( $data ))
                $result['error']['propBase'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
            if(!sendleadmail( $data ))
                $result['error']['email'] = 'Lead email not sent.';
        }
    
        if($result['error']){
            $result['type'] = 'error';
        } else {
            $result['type'] = 'success';
            if(!del_data())
                $result['error']['db'] = 'There was an error processing your details. Please call us on +44 (0)161 322 2222 to disucss your enquiry.';
        }
    } else {
        $result['error']['db'] = 'No Record.';
    }
    
    echo json_encode( $result );
    die();
}

function isEmail($email) { // Email address verification, do not edit.
    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}


function initialInsert( $data ){
    global $wpdb, $country;
    
    $table = 'select_enquiries';
    
    if($data['source']=='Email'||$data['source']=='3rd Party Lead Gen'){
        $campaign_name = ( $data['sourceinfo'] ) ? $data['sourceinfo'] : 'No '.$data['source'].' Campaign Name';
    }else{
        $campaign_name = $_SESSION['seotracking']['campaign_name'];
    }
    
    $data = array( $data['contact-name'], $data['contact-surname'], $data['contact-email'], $data['contact-phone'], $data['comment'], $country['countryCode'], $data['page'], $data['development'], $data['source'], $data['emailtemp'], $campaign_name, $_SESSION['seotracking']['campaign_content'], $_SESSION['seotracking']['campaign_term'], $data['addemails'] );
    
    $dbins = $wpdb->query( 
        $wpdb->prepare("
            INSERT INTO $table
            ( name,surname,email,tel,comment,country,page,development,source,emailtemp,ppc_campaign,ppc_adgp,ppc_kw,add_emails  )
            VALUES ( %s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s )", 
            $data
        )
    );
    
    if($dbins === FALSE){
        return false;
    } else {
        session_start();
        $_SESSION['contact_id'] = $wpdb->insert_id;
        return true;
    }
}

function get_data( $id = null ){
    global $wpdb;
    session_start();
    $id = (isset($_SESSION['contact_id'])) ? $_SESSION['contact_id'] : $id;
    
    if($id == null){
        return false;
    } else {
        $table = 'select_enquiries';
        $query = "SELECT * FROM $table WHERE id='$id';";
        $dbget = $wpdb->query($query);
    
        if($dbget === FALSE){
            return false;
        } else {
            return $wpdb->get_row($query, ARRAY_A);
        }
    }
}

function del_data(){
    global $wpdb;
    
    $id = $_SESSION['contact_id'];
    
    if($id == null){
        return false;
    } else {
        $table = 'select_enquiries';
        $dbdel = $wpdb->query( 
            $wpdb->prepare("
                UPDATE $table
                SET inpb = 1
		WHERE id = %d",
	        $id
            )
        );
        if($dbdel === FALSE){
            return false;
        }else{
            unset($_SESSION['contact_id']);
            return true;
        }
    }
}

function sp_sendmail( $email ){
    global $site;
    require_once get_template_directory().'/includes/Swiftmailer/lib/swift_required.php';
    
    $emailAdd  = (isset($email['PersonEmail'])) ? $email['PersonEmail'] : $email['contact-email'];
    $firstname = (isset($email['FirstName'])) ? $email['FirstName'] : $email['contact-name'];
    $surname   = (isset($email['LastName'])) ? $email['LastName'] : $email['contact-surname'];
    $emailtemp = (isset($email['emailtemp'])) ? $email['emailtemp'] : 'select-email-template-v1';
    //$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
      //              ->setUsername('mail.selectproperty@gmail.com')
        //            ->setPassword('xumjatrielyvviip');
    //$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
    //$transport = Swift_MailTransport::newInstance();
    $transport = Swift_SmtpTransport::newInstance('localhost', 25);
    
    $mailer = Swift_Mailer::newInstance( $transport );
    
    $template = get_stylesheet_directory().'/includes/emailTemps/select-contact-confirmation.php'; 
    switch ($email['Enquiry_Nature__pc']){
        case 'Phone':
            $email_title = 'call you in the next 30 mins.';
            $email_info  = 'Your request was recieved at '.date('H:i').' on '.date('d/m/Y').'. We will endevour to call you by '.$email['Sup__c'];
            break;
        case 'Email':
            $email_title = 'email you with our latest investment details.';
            $email_info  = 'Here is a summary of your selected email options: '.$email['Sup__c'];
            break;
        case 'Scheduled':
            $email_title = 'call you at an arranged time.';
            $email_info  = 'Someone will call you within your selected time slot: <strong>'.$email['Sup__c'].'</strong>';
            break;
        default:
            $email_title = '';
            $email_info  = '';
            $template = get_stylesheet_directory().'/includes/emailTemps/'.$emailtemp.'.php';
            break;
    }   
    
    include $template;
    
    $message2 = Swift_Message::newInstance()
        ->setSubject('Welcome to Select Property')
        ->setFrom(array($site['email'] => $site['name'].' Info'))
        ->setTo(array($emailAdd => $firstname.' '.$surname))
        ->setBody($wel_text)
        ->addPart($wel_HTML, 'text/html');
    
    if (!$mailer->send($message2)) {
        return false;
    }
    
    return true;
} 

function sendleadmail( $email ){
    
    require_once get_template_directory().'/includes/Swiftmailer/lib/swift_required.php';
    
    /*$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
                    ->setUsername('mail.selectproperty@gmail.com')
                    ->setPassword('xumjatrielyvviip');*/
    $transport = Swift_SmtpTransport::newInstance('localhost', 25);
    $mailer = Swift_Mailer::newInstance( $transport );
    
    $datestamp = 'Time: '.date("F j, Y, g:i a");
    
    $to = array('leads@selectproperty.com', 'martin.vernon@selectproperty.com');
    if(isset($email['addemails']) && $email['addemails'] != ''){
        $addEmails = explode(',',$email['addemails']);
        $to = array_merge($to, $addEmails);
    }
    
    $text = 'New Landing page Enquiry details:'."\n";
    $HTML = '<html><body><p>New Landing page Enquiry details:</p><p>';
    foreach($email as $k=>$v){
        $text .= $k . ': ' . $v . "\n";
        $HTML .= $k . ': ' . $v . '<br>';
    }
    $text .= $datestamp."\n".'type: text';
    $HTML .= $datestamp."</p>".'<p>type: html</p>';
    $HTML .= '</body></html>';

    $message = Swift_Message::newInstance()
        ->setSubject('New enquiry from: '.$email['FirstName'].' '.$email['LastName'])
        ->setFrom(array('info@selectproperty.com' => 'Select Property Info'))
        ->setTo( $to )
        ->setBody($text)
        ->addPart($HTML, 'text/html');

    if (!$mailer->send($message)) {
        return false;
    }
    
    return true;
}

function set_propBase_data ( $data ){
    global $country;
    session_start();
    
    $proenquiry['FirstName']   = $data['name'];
    $proenquiry['LastName']    = $data['surname'];
    $proenquiry['PersonEmail'] = $data['email'];
    $proenquiry['Phone']       = $data['tel'];
    $proenquiry['Description'] = $data['comment'];
    
    // Location Info
    
    switch ($data['development']) {
        case 'first_street':
            $proenquiry['Preferred_Country__c']              = 'United Kingdom';
            // Original Preferred Country
            $proenquiry['Original_Preferred_Country__c']     = 'United Kingdom';
            // Preferred City
            $proenquiry['Preferred_City__c']                 = 'Manchester';
            // Original Preferred City
            $proenquiry['Original_Preferred_City__c']        = 'Manchester';
            // Preferred Development
            $proenquiry['Preferred_Development__c']          = 'Vita Student at First Street';
            // Original Preferred Development
            $proenquiry['Original_Preferred_Development__c'] = 'Vita Student at First Street';
            break;
        case 'crosshall':
            $proenquiry['Preferred_Country__c']              = 'United Kingdom';
            $proenquiry['Original_Preferred_Country__c']     = 'United Kingdom';
            $proenquiry['Preferred_City__c']                 = 'Liverpool';
            $proenquiry['Original_Preferred_City__c']        = 'Liverpool';
            $proenquiry['Preferred_Development__c']          = 'Vita Student at Crosshall';
            $proenquiry['Original_Preferred_Development__c'] = 'Vita Student at Crosshall';
            break;
        case 'tinlings':
            $proenquiry['Preferred_Country__c']              = 'United Kingdom';
            $proenquiry['Original_Preferred_Country__c']     = 'United Kingdom';
            $proenquiry['Preferred_City__c']                 = 'Liverpool';
            $proenquiry['Original_Preferred_City__c']        = 'Liverpool';
            $proenquiry['Preferred_Development__c']          = 'Vita Student at Tinlings';
            $proenquiry['Original_Preferred_Development__c'] = 'Vita Student at Tinlings';
            break;
        case 'chapel':
            $proenquiry['Preferred_Country__c']              = 'United Kingdom';
            $proenquiry['Original_Preferred_Country__c']     = 'United Kingdom';
            $proenquiry['Preferred_City__c']                 = 'Liverpool';
            $proenquiry['Original_Preferred_City__c']        = 'Liverpool';
            $proenquiry['Preferred_Development__c']          = 'Vita Student at The Chapel';
            $proenquiry['Original_Preferred_Development__c'] = 'Vita Student at The Chapel';
            break;
        case 'bay_central': 
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'Bay Central';
            $proenquiry['Original_Preferred_Development__c'] = 'Bay Central';
            break;
        case 'west_ave':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'West Ave';
            $proenquiry['Original_Preferred_Development__c'] = 'West Ave';
            break;
        case 'the_torch':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'The Torch';
            $proenquiry['Original_Preferred_Development__c'] = 'The Torch';
            break;
        case 'botanica':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'Botanica';
            $proenquiry['Original_Preferred_Development__c'] = 'Botanica';
            break;
        case 'royal_oceanic':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'Royal Oceanic';
            $proenquiry['Original_Preferred_Development__c'] = 'Royal Oceanic';
            break;
        case 'yacht_bay':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'Yacht Bay';
            $proenquiry['Original_Preferred_Development__c'] = 'Yacht Bay';
            break;
        case 'pacific':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Ras Al Khaimah';
            $proenquiry['Original_Preferred_City__c']        = 'Ras Al Khaimah';
            $proenquiry['Preferred_Development__c']          = 'Pacific';
            $proenquiry['Original_Preferred_Development__c'] = 'Pacific';
            break;
        case 'uk':
            $proenquiry['Preferred_Country__c']              = 'United Kingdom';
            $proenquiry['Original_Preferred_Country__c']     = 'United Kingdom';
            $proenquiry['Preferred_City__c']                 = '';
            $proenquiry['Original_Preferred_City__c']        = '';
            $proenquiry['Preferred_Development__c']          = 'UK Page';
            $proenquiry['Original_Preferred_Development__c'] = 'UK Page';
            break;
        case 'dubai':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Dubai';
            $proenquiry['Original_Preferred_City__c']        = 'Dubai';
            $proenquiry['Preferred_Development__c']          = 'Dubai Page';
            $proenquiry['Original_Preferred_Development__c'] = 'Dubai Page';
            break;
        case 'rak':
            $proenquiry['Preferred_Country__c']              = 'United Arab Emirates';
            $proenquiry['Original_Preferred_Country__c']     = 'United Arab Emirates';
            $proenquiry['Preferred_City__c']                 = 'Ras Al Khaimah';
            $proenquiry['Original_Preferred_City__c']        = 'Ras Al Khaimah';
            $proenquiry['Preferred_Development__c']          = 'RAK Page';
            $proenquiry['Original_Preferred_Development__c'] = 'RAK Page';
            break;
        default:
            $proenquiry['Preferred_Country__c']              = '';
            $proenquiry['Original_Preferred_Country__c']     = '';
            $proenquiry['Preferred_City__c']                 = '';
            $proenquiry['Original_Preferred_City__c']        = '';
            $proenquiry['Preferred_Development__c']          = '';  
            $proenquiry['Original_Preferred_Development__c'] = '';
    }

    // Mailing Country
    $proenquiry['pb__Country__pc']     = $country['countryName'];
    $proenquiry['Tracking_Country__c'] = $country['countryCode'];
    
    // Technical Info
    // Lead Status
    $proenquiry['Lead_Status__c']  = 'Weblead';
    $proenquiry['Lead_Status__pc'] = 'Web Lead';
    $proenquiry['pb__Status__c']   = 'Qualified';
    $proenquiry['RecordType']      = 'IndividualClient';
    $proenquiry['IP_Address__c']   = $_SERVER['REMOTE_ADDR'];

    // Tracking Page
    $proenquiry['Tracking_Page__c']          = $data['page'];
    // Original Tracking Page
    $proenquiry['Original_Tracking_Page__c'] = $data['page'];
    
    $proenquiry['success_page'] = 'http://www.selectproperty.com/thank-you';
    
    // Select Property Contact Choice system
    // Enquiry Nature
    $proenquiry['Enquiry_Nature__pc'] = '';
    // Subsidiary Info
    $proenquiry['Sup__c'] = '';
    
    $proenquiry['Tracking_Keyword__c']          = $_SESSION['seotracking']['campaign_term'];
    $proenquiry['Original_Tracking_Keyword__c'] = $_SESSION['seotracking']['campaign_term'];
    $proenquiry['Web_Tracking_Note__c']         = $_SESSION['seotracking']['web_tracking'];
        
    // if the seotracking / Google cookie source medium value is CPC then overide the source to PPC
    if($_SESSION['seotracking']['campaign_medium'] == 'CPC' || $_SESSION['seotracking']['campaign_medium'] == 'cpc'){
        $proenquiry['Lead_Source_SP__c']       = 'PPC';
        $proenquiry['Original_Lead_Source__c'] = 'PPC';
    }else{
        $proenquiry['Lead_Source_SP__c']       = ($data['source']) ? $data['source'] : 'Website';
        $proenquiry['Original_Lead_Source__c'] = ($data['source']) ? $data['source'] : 'Website';
    }
    
    //Source Category
    if( $proenquiry['Lead_Source_SP__c'] == 'Website' || $proenquiry['Lead_Source_SP__c'] == 'website' ){
        $proenquiry['Lead_Source_SP__c']       = 'Website';
        $proenquiry['Original_Lead_Source__c'] = 'Website';
        
        //Source Information
        switch( site_url() ){
            case 'http://www.selectproperty.ae':
                $proenquiry['Source_Information__c']          = 'Select Property AE';
                $proenquiry['Original_Source_Information__c'] = 'Select Property AE';
                break;
            case 'http://www.vitastudent.com':
                $proenquiry['Source_Information__c']          = 'Vita Student';
                $proenquiry['Original_Source_Information__c'] = 'Vita Student';
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            case 'http://www.vitainvest.com':
                $proenquiry['Source_Information__c']          = 'Vita Invest';
                $proenquiry['Original_Source_Information__c'] = 'Vita Invest';
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            case 'http://www.vitaventures.com':
                $proenquiry['Source_Information__c']          = 'Vita Ventures';
                $proenquiry['Original_Source_Information__c'] = 'Vita Ventures';
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            default:
                $proenquiry['Source_Information__c']          = 'Select Property';
                $proenquiry['Original_Source_Information__c'] = 'Select Property';
        }
        
        if( $campaignterm == '' ){
            //No Keyword so Direct or Referral ?? NW needs to look at
            //$proenquiry['Source_Category__c'] = 'Referral';
            //$proenquiry['Original_Source_Category__c'] = 'Referral';

            $proenquiry['Source_Category__c']          = 'Direct';
            $proenquiry['Original_Source_Category__c'] = 'Direct';
        } elseif ( $campaignterm == '(not provided)' ) {
            //Secure search so (not-provided)
            $proenquiry['Source_Category__c']          = '(not provided)';
            $proenquiry['Original_Source_Category__c'] = '(not provided)';
        } else {
            //keyword present so need to check brand or developemnt
            //presume neither
            $bodFlag     = false;
            $brandSelect = false;
            
            if ( brandArraySearch($campaignterm) ) {
                $proenquiry['Source_Category__c']          = 'Brand';
                $proenquiry['Original_Source_Category__c'] = 'Brand';
                $bodFlag = true;

                if ( stristr($campaignterm, 'select') )
                    $brandSelect = true;
            }

            if(!$brandSelect){
                if( devArraySearch($campaignterm) ){
                    $proenquiry['Source_Category__c']          = 'Development';
                    $proenquiry['Original_Source_Category__c'] = 'Development';
                    $bodFlag = true;
                }
            }
            
            // if neither then set as empty and set Lead Source as SEO
            if(!$bodFlag){
                $proenquiry['Lead_Source_SP__c']           = 'SEO';
                $proenquiry['Original_Lead_Source__c']     = 'SEO';
                $proenquiry['Source_Category__c']          = '';
                $proenquiry['Original_Source_Category__c'] = '';
            }
        }
    } elseif ( stristr( $proenquiry['Lead_Source_SP__c'], 'PPC' ) ) {
        switch( site_url() ){
            case 'http://www.selectproperty.ae':
                $proenquiry['Lead_Source_SP__c'] = "PPC UAE";
                $proenquiry['Original_Lead_Source__c'] = "PPC UAE";
                break;
            case 'http://www.vitastudent.com':
                $proenquiry['Lead_Source_SP__c'] = "PPC Vita";
                $proenquiry['Original_Lead_Source__c'] = "PPC Vita";
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            case 'http://www.vitainvest.com':
                $proenquiry['Lead_Source_SP__c'] = "PPC Vita";
                $proenquiry['Original_Lead_Source__c'] = "PPC Vita";
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            case 'http://www.vitaventures.com':
                $proenquiry['Lead_Source_SP__c'] = "PPC Vita";
                $proenquiry['Original_Lead_Source__c'] = "PPC Vita";
                $proenquiry['Preferred_Country__c']           = 'United Kingdom';
                $proenquiry['Original_Preferred_Country__c']  = 'United Kingdom';
                break;
            default:
                $proenquiry['Lead_Source_SP__c'] = "PPC UK";
                $proenquiry['Original_Lead_Source__c'] = "PPC UK";
        }
        $proenquiry['Source_Information__c']          = ( $_SESSION['seotracking']['campaign_name'] ) ? $_SESSION['seotracking']['campaign_name'] : 'No PPC Campaign Name';
        $proenquiry['Original_Source_Information__c'] = ( $_SESSION['seotracking']['campaign_name'] ) ? $_SESSION['seotracking']['campaign_name'] : 'No PPC Campaign Name';
        $proenquiry['Source_Category__c']             = ( $_SESSION['seotracking']['campaign_content'] ) ? $_SESSION['seotracking']['campaign_content'] : 'No PPC Ad Group';
        $proenquiry['Original_Source_Category__c']    = ( $_SESSION['seotracking']['campaign_content'] ) ? $_SESSION['seotracking']['campaign_content'] : 'No PPC Ad Group';
    } elseif ( $proenquiry['Lead_Source_SP__c'] == 'Email' || $proenquiry['Lead_Source_SP__c'] == '3rd Party Lead Gen' ) {
        // We don't do any email tracking, but if we did, the code would be here.
        $proenquiry['Source_Information__c']          = $data['ppc_campaign'];
        $proenquiry['Original_Source_Information__c'] = $data['ppc_campaign'];
        $proenquiry['Source_Category__c']             = '';
        $proenquiry['Original_Source_Category__c']    = '';
    }
    
    return $proenquiry;
}

function brandArraySearch( $inString , $inDelim=' ' ){
  $brandTerms  = array('select','vita');
  $inStringAsArray = explode( $inDelim , strtolower($inString) );
  if (count( array_intersect( $brandTerms , $inStringAsArray) )>0)
      return true;
}

function devArraySearch($string) {
    $devs = array('first st','first street','crosshall','tinlings','chapel','west avenue','west ave','bay central','torch','point','botanica','royal oceanic','yacht Bay','pacific');
    foreach ($devs as $value) {
        if (!stristr($string, $value) === FALSE)
            return true;
    }
}

function sp_do_propBase( $data ){
    //Initialize the $query_string variable for later use
    $query_string = ""; 

    //If there are POST variables
    if ($data) {
        $query_string = http_build_query($data, '&');
        $query_string .= '&return_error=false';
    }
    //Check to see if cURL is installed ...
    if (!function_exists('curl_init')){
        echo 'Sorry cURL is not installed!';
        return false;
    }

    //The original form action URL from Step 2 :)
    $url = 'https://selectproperty.secure.force.com/pb__WebserviceWebToProspect?'.$query_string;

    //Open cURL connection
    $ch = curl_init();

    //Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    //Set some settings that make it all work :)
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);

    //Execute SalesForce web to lead PHP cURL
    if(curl_exec($ch) === false){
        echo 'Curl error: ' . curl_error($ch);
        return false;
    }

    //close cURL connection
    curl_close($ch);
    
    return true;
} 

function draw_icon( $icon, $text ){
    return '<div class="icon '.$icon.'">'.$text.'</div>';
}

function get_country() {
    global $country;
    include_once('ip2locationlite.class.php');
    
    //Set geolocation cookie
    if(!$_COOKIE["geolocation"]){
      $ipLite = new ip2location_lite;
      $ipLite->setKey('7ce2631969111ddcbfbbf67453338440fd1aed570febfbbcffb5e5a1ec1eae89');

      $visitorGeolocation = $ipLite->getCountry($_SERVER['REMOTE_ADDR']);
      if ($visitorGeolocation['statusCode'] == 'OK') {
        $country = $visitorGeolocation;
        $data = base64_encode(serialize($visitorGeolocation));
        setcookie("geolocation", $data, time()+3600*24*7); //set cookie for 1 week
      }
    }else{
      $country = unserialize(base64_decode($_COOKIE["geolocation"]));
    }  
}
add_action( 'init', 'get_country' );

function set_tracking(){
    session_start();
    global $site;
    $changed = false;
    
    if(isset($_GET['kw']) && isset($_SESSION['seotracking']['campaign_term'])){
        if($_GET['kw'] != $_SESSION['seotracking']['campaign_term'])
            $changed = true;
    }
    
    if(!isset($_SESSION['seotracking']) || $changed == true){
        // Google tracking code
        // Visitior Tracking
        include_once('class.gaparse.php');
        $aux = new GA_Parse($_COOKIE);

        $tracking =  " Date of first visit: ".$aux->first_visit;
        $tracking .= " Date of previous visit: ".$aux->previous_visit;
        $tracking .= " Date of current visit: ".$aux->current_visit_started;
        $tracking .= " Times visited: ".$aux->times_visited;

        $_SESSION['seotracking']['campaign_source']  = $aux->campaign_source;
        $_SESSION['seotracking']['campaign_name']    = (isset($_GET['source']) && $_GET['source'] == 'ppc') ? $_GET['cmp'] : $aux->campaign_name;
        $_SESSION['seotracking']['campaign_medium']  = (isset($_GET['source']) && $_GET['source'] == 'ppc') ? 'cpc' : $aux->campaign_medium;
        $_SESSION['seotracking']['campaign_content'] = (isset($_GET['source']) && $_GET['source'] == 'ppc') ? $_GET['ag'] : $aux->campaign_content;
        $_SESSION['seotracking']['campaign_term']    = (isset($_GET['kw'])) ? $_GET['kw'] : $aux->campaign_term;
        $_SESSION['seotracking']['web_tracking']     = $tracking;
        //print_r($_SESSION['seotracking']);
    }
    switch(site_url()){
        case 'http://www.vitastudent.com':
            $site['name']  = 'Vita Student';
            $site['email'] = 'info@vitastudent.com';
            $site['tel']   = '+44 (0)161 709 7777';
            $site['logo']  = '/images/vs-logo-full-32.png';
            break;
        default:
            $site['name']  = 'Select Property';
            $site['email'] = 'info@selectproperty.com';
            $site['tel']   = '+44 (0) 161 322 2222';
            $site['logo']  = '/assets/img/select-property-logo.gif';
    }
}
add_action( 'init', 'set_tracking' );

if(function_exists('wpb_map')){
    wpb_map( array(
        "name" => __("SP Contact Form"),
        "base" => "draw_sp_form",
        "class" => "",
        "controls" => "full",
        "category" => __('Select Property'),
        "params" => array(
           array(
              "type" => "textfield",
              "holder" => "div",
              "class" => "",
              "heading" => __("Form Class"),
              "param_name" => "class",
              "value" => __('relative'),
              "description" => __("Class to add to form. Defaults to relative.")
           ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Form Title Text"),
               "param_name" => "title",
               "value" => __("Request full investment details"),
               "description" => __("")
           ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Form SubTitle Text"),
               "param_name" => "subtitle",
               "value" => __("Fill out the form below."),
               "description" => __("")
           ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Form Action URL"),
               "param_name" => "action",
               "value" => admin_url('admin-ajax.php'),
               "description" => __("")
           ),
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Forms Method"),
              "param_name" => "method",
              "value" => array("Post" => "post", "Get" => "get"),
              "description" => __("")
           ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Thanks URL"),
               "param_name" => "thanks",
               "value" => site_url('/thank-you'),
               "description" => __("")
           ),
           array(
               "type" => "textfield",
               "holder" => "div",
               "class" => "",
               "heading" => __("Submit Button Text"),
               "param_name" => "submit",
               "value" => __("Send me Details"),
               "description" => __("")
           ),
           array(
              "type" => "textarea_html",
              "holder" => "div",
              "class" => "",
              "heading" => __("Small Print text"),
              "param_name" => "small",
              "value" => __('<em><strong>Note:</strong> Fields marked with <span class="required">*</span> are required.</em>'),
              "description" => __("")
           ),
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Preferred Development"),
              "param_name" => "dev",
              "value" => array("Contact Us" => "contact_us",
                               "First Street" => "first street",
                               "Tinlings" => "tinlings",
                               "Crosshall" => "crosshall",
                               "Chapel" => "chapel",
                               "West Ave" => "west ave",
                               "Bay Central" => "bay central",
                               "The Torch" => "the torch",
                               "Botanica" => "botanica",
                               "Royal Oceanic" => "royal oceanic",
                               "Yacht Bay" => "yacht bay",
                               "Pacific" => "pacific",
                               "United Kingdom" => "uk",
                               "Dubai" => "dubai",
                               "RAK" => "rak"),
              "description" => __("")
           ),
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Lead Source"),
              "param_name" => "source",
              "value" => array("Website" => "Website",
                               "Email" => "Email",
                               "3rd Party Lead Gen" => "3rd Party Lead Gen",
                               "PPC" => "PPC",
                               "SEO" => "SEO"),
              "description" => __("")
           ),
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Modal Choices"),
              "param_name" => "modal_box",
              "value" => array("Yes" => "1", "No" => "0"),
              "description" => __("Turn on the modal choices system.")
           ),  
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Email Template"),
              "param_name" => "emailtemp",
              "value" => array("SP Customer Email 1" => 'select-email-template-v1'),
              "description" => __("Customer Facing Email Template")
           ),
           array(
              "type" => "dropdown",
              "holder" => "div",
              "class" => "",
              "heading" => __("Comment"),
              "param_name" => "comment",
              "value" => array("No" => "0", "Yes" => "1"),
              "description" => __("Turn on the comment field.")
           ),  
        )
     ) );
}
?>