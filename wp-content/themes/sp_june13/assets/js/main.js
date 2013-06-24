jQuery(function ($) {
    var OSX = {
        container: null,
        init: function () {
            $('.contact_form form, #call-now-form form').bind('submit', function(e){
                e.preventDefault();	
                var url     = $(this).attr('action');
                var method  = $(this).attr('method');
                var data    = $(this).serialize();
                var parent  = $(this).parent().parent();
                var thanks  = $(this).parent().parent().parent().find('#thanks-new');                              
                var process = $(this).parent().find('.ajax-console-process');
                var alert   = $(this).find('.alert');
                var consoleError = '';
                
                process.fadeIn();

                $.ajax({
                    url      : url,
                    method   : method,
                    data     : data,
                    dataType : "json",
                    error    : function( d, c, e ){
                        console.log( d+':'+c+':'+e );
                    },
                    success  : function ( d ){
                        if( d.type == 'success' ){
                            
                            console.log( 'Google Tracking Info: '+d.ga_action+':'+d.ga_label );
                            _gaq.push(['_trackEvent', 'Contact-Page', d.ga_action, d.ga_label,, false]);
                            
                            if( d.modal == '1' ) {
                                $.modal.close();
                                $("#osx-modal-content").modal({
                                        overlayId: 'osx-overlay',
                                        containerId: 'osx-container',
                                        closeHTML: null,
                                        minHeight: 80,
                                        opacity: 65, 
                                        position: ['0',],
                                        overlayClose: false,
                                        escClose: false,
                                        onOpen: OSX.open,
                                        onClose: OSX.close,
                                        onShow: OSX.show
                                });
                            } else {
                                if(d.modal == '0'){
                                    //eg. brochure sent, so need to fade down spinner and say thanks
                                    if($('.simplemodal-wrap').is(':visible')){
                                        $('.simplemodal-wrap').fadeOut(400, function(){
                                            thanksMsg = '<div id="thanks-new"><h2>Thank You for contacting Select Property</h2><p>The information you requested will be sent to you shortly and an expert property advisor will be in touch to discuss your requirements. It is our aim to contact you as soon as possible however we are receiving an extremely high number of enquiries so we urge you to contact us directly if you would like to speak to an advisor straight away.</p><p class="thanks">In the meantime please continue to browse our website by clicking <a href="#" class="thanks-simplemodal-close" title="Close Contact form">here.</a></p></div>';
                                            thanksMsg = thanksMsg + '<div id="thanksFooter" style="display: block;">Tel: +44 (0)161 322 2222 | Email: <a href="mailto:info@selectproperty.com" title="Email Us">info@selectproperty.com</a><img src="http://www.selectproperty.com/wp-content/themes/SelectProperty_new/images/thanks/logo-bottom.png" alt="Select Property"></div>'; 
                                            $(this).html('').append( thanksMsg ).fadeIn(); 
                                        });
                                    } else {
                                        process.fadeOut();
                                        $('.basic-modal-content').modal({overlayClose:true,opacity:75,minWidth:732,minHeight:375});
                                    }
                                } else {
                                    //presume no modal value so already in amongst the 3 choice system.
                                    OSX.resize( parent, thanks );
                                }
                            }
                        } else {
                            if( d.error ){                                
                                for( var key in d.error ){
                                    if (d.error.hasOwnProperty(key)){
                                        consoleError = consoleError+'<li>'+d.error[key]+'</li>';
                                        $('#'+key).addClass('error').val(d.error[key]);
                                    }
                                }
                                consoleError = '<div class="message"><strong>Attention!</strong> Please correct the errors below and try again.<ul class="error-messages">' + consoleError + '</ul></div>';
                                alert.addClass('alert-error').append( consoleError ).fadeIn().find('.close').show();
                            }
                        }
                    }
                });
            }); 
            $(".alert .close").on("click", function(e){
                e.preventDefault();
                var parent  = $(this).parent();
                var message = parent.find('.message');
                parent.fadeOut(function(){
                   $(this).removeClass('alert-error');
                   message.remove();
                });
                $('.ajax-console-process').fadeOut();
            });
            $('.ajax-console-process').on("click", function(){
               $(this).parent().find('.alert .close').trigger('click'); 
            });
        },
        open: function (d) {
            var self = this;
            self.container = d.container[0];
            d.overlay.fadeIn('slow', function () {
                $("#osx-modal-content", self.container).show();
                var title = $("#osx-modal-title", self.container);
                title.show();
                d.container.slideDown('slow', function () {
                    setTimeout(function () {
                        var h = $("#osx-modal-data", self.container).height()
                                + title.height()
                                + 20; // padding
                        d.container.animate(
                            {height: h}, 
                            200,
                            function () {
                                $("div.close", self.container).show();
                                $("#osx-modal-data", self.container).fadeIn();
                            }
                        );
                    }, 300);
                });
            });
        },
        close: function (d) {
            var self = this; // this = SimpleModal object
            d.container.animate(
                {top:"-" + (d.container.height() + 20)},
                500,
                function () {
                        self.close(); // or $.modal.close();
                }
            );
            $.ajax({
               url      : 'http://localhost/wp-admin/admin-ajax.php',
               method   : 'post',
               data     : { action : 'process_lead' },
               dataType : "json",
               success  : function( d ){
                    if( d.type == 'error' ){
                        console.log( d.error );
                    }
               }
            });
            $('.ajax-console-process').fadeOut();
        },
        show: function (d) {
            $('#osx-container #arrange-time .contact_form .datepicker select, #osx-container #email-me .contact_form select').uniform();

            $('#osx-container #arrange-time .contact_form .datepicker').datepicker({
                onSelect : function ( date, data ){
                    $(this).parent().find('.date_day').val( data.selectedDay );
                    $(this).parent().find('.date_month').val( data.selectedMonth+1 );
                    $(this).parent().find('.date_year').val( data.selectedYear );
                }
            });

            $( "#osx-container #arrange-time .contact_form .datepicker .selector" ).hide();
        },
        resize: function (c, d) {
            var self = $("#osx-container");
            var title = $("#osx-modal-title");
            var h = d.height() + title.height() + 103;

            self.find('#thanksFooter').fadeOut();
            c.fadeOut();

            self.delay(500).animate(
                {height: h},
                200,
                function () {
                    self.find('#thanksFooter').fadeIn();
                    d.fadeIn();
                }
            );
        }
    };

    OSX.init();

    $('.buttons a').bind('click', function(e){
        e.preventDefault();
        var rel = $(this).attr('rel');
        var container = $(this).parent().parent();
        OSX.resize( container, $('#'+rel) );
        if( rel == 'call-me' )
            $('#call-now-form form').submit();
    });
    
    $('.thanks-simplemodal-close').bind('click', function(e){
       e.preventDefault();
       $.modal.close();
    });
    
    $('.contact_form form p input[type="text"], .contact_form form p input[type="email"], .contact_form form p textarea').bind('focus', function(){
       $(this).removeClass('error');
       $(this).val('');
    });
});