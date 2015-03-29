//jQuery.noConflict();

(function($) {
    $(function() {

        var bf_path = '/backformer';
        bf_form(); //init form
        new_capcha();

        //update capcha
        function new_capcha() {
            $(".bf-img-capcha").on("click", function() {
                update_capcha();
            });
        }

        //init popup windows
        $('[data-bf-init="popup"]').on("click", function(e) {
            e.preventDefault();
            if (typeof $('[data-bf-init="popup"]').fancybox == 'function') {
                $.fancybox({
                    type: 'ajax',
                    beforeLoad: function() {
                        this.href = bf_path + '/configs/default/form.html';
                    },
                    beforeShow: function() {

                        $(".bf-img-capcha").off();
                        new_capcha();
                        update_capcha();

                        $( "form[data-bf-config]" ).off();
                        bf_form();

                    }
                });
            }
        });

        function update_capcha() {
            $.post(bf_path + "/core/model/kcaptcha/index.php");
            $('.bf-img-capcha').attr('src', bf_path + '/core/model/kcaptcha/index.php?' + Math.random())
        }

        function bf_form() {

            $('form[data-bf-config]').on('submit', function(e) {
                e.preventDefault();

                var options = {
                    beforeSubmit: showRequest, // pre-submit callback 
                    success: showResponse, // post-submit callback  
                    url: bf_path + '/index.php', // override for form's 'action' attribute 
                    type: 'post', // 'get' or 'post', override for form's 'method' attribute 
                    dataType: 'json', // 'xml', 'script', or 'json' (expected server response type)  
                    //$.ajax options can be used here too, for example: 
                    //timeout:   3000 
                };

                var form = $(this);

                var config = $(this).data("bf-config");
 
                if (typeof config == 'undefined' || config.length < 1) {
                    config = 'default';
                } 

                $.post(
                    bf_path + "/index.php", {
                        'type': 1,
                        'bf-config': config
                    },
                    function(data) { 
                        $('[name="bf-config"]').remove();
                        $('[name="bf-token"]').remove();

                        //set config
                        form.append('<input name="bf-config" type="hidden" value="' + config + '" />');
                        //set spam protection
                        form.append('<input name="bf-token" type="hidden" value="' + data['token'] + '" />');
                        //set submit form
                        form.ajaxSubmit(options);
                    }
                );
            });
        }

        // pre-submit callback 
        function showRequest(formData, jqForm, options) {
            //var queryString = $.param(formData);
            return true;
        }

        // post-submit callback 
        function showResponse(responseText, statusText, xhr, $form) {

            $('.bf-status ').remove();
            $form.before('<div class="bf-status bf-status-' + responseText['status'] + '">' + responseText['value'] + '</div>');

            if (responseText['status'] > 0) {
                $form.hide();
                update_capcha();

                setTimeout(
                    function() {
                        $('.fancybox-close').click(); //if popup
                    }, 2000
                );

                setTimeout(
                    function() {
                        $form.show();
                        $('.bf-status ').remove();
                        $form.clearForm();
                    }, 3000
                );
            }

        }

    });

})(jQuery);
