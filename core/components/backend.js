(function($) {
    $(function() {

        function listener(event) {
            if( event.origin != 'http://learn.javascript.ru') { 
                // что-то прислали с чужого домена - проигнорируем..    
                //return;
            }
               
                //parent.gow = 433;
                //parent.goh = 547;
                parent.postMessage('433,547', '*');
                document.getElementById("msg").innerHTML = "получено: " + event.data;
        }

        if (window.addEventListener){
            window.addEventListener("message", listener, false);
        } else {
            window.attachEvent("onmessage", listener);
        }

 
        $( ".link" ).on( "click", function() {
           
            parent.postMessage('1', '*');

            // get iframe height and width
var current_height = 447;
var current_width = 733;

// resize height
 parent.$('.fancybox-inner').height(current_height);

// resize width
 parent.$('.fancybox-outer').width(current_width + 30);
 parent.$('.fancybox-wrap').width(current_width + 30);
 parent.$('.fancybox-content').width(current_width + 30);
 parent.$('.fancybox-inner').width(current_width + 30);

// center the thing - vertically and horizontally
 

            return false;
        });
 
        var bf_path = '/backformer2';

        $( ".img-capcha").on( "click", function() {
            update_capcha(bf_path);
        });

        set_token(bf_path);
        set_name_config();

        $('.backformer form').on('submit', function(e) {
            e.preventDefault(); 
 
            $(this).ajaxSubmit(
                jQuery.proxy(
                    function(data){ 
                        if(data['status'] > 0) {
                            $(this).parent().parent().find('.bf-status').show()
                            .html(data['value']).css('background', 'green'); 

                            $(this).parent().hide();
                            $(this).resetForm();

                            setTimeout(
                                jQuery.proxy(
                                    function(){
                                        $('.fancybox-close').click(); 
                                        
                                    } , this
                                ), 2000
                            );

                              parent.go();

                            setTimeout(
                                jQuery.proxy(
                                    function(){ 
                                        $(this).parent().show();
                                        $(this).parent().parent().find('.bf-status').hide();


                                        
                                    } , this
                                ), 3000
                            );

                            update_capcha(bf_path);
                            set_token(bf_path); 
                        } else {
                            $(this).parent().parent().find('.bf-status').show()
                            .html(data['value']).css('background', 'red');
                        }
                }, this)
            );
        });
    });

function update_capcha(bf_path) {
    $.post( bf_path + "/core/model/kcaptcha/index.php");
    $('.img-capcha').attr('src', bf_path + '/core/model/kcaptcha/index.php?'+Math.random())
}

function set_token(bf_path) {
    $.post(
        bf_path + "/index.php",
        {
            type: 1 
        },
        function(data) {
           $('.bf-token').val(data['token'])
        }
    );
}

function set_name_config() {
    var hash = location.hash;
    $('.bf-config').val(hash.replace('#',''));
}

})(jQuery); 

