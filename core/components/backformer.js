//jQuery.noConflict();

(function($) {
    $(function() {

        var bf_path = '/backformer';

        bind_event_capcha();
        bind_event_popup();
        init_form();

        function bind_event_popup() {
            $('[data-bf-config]').on("click", function(e) {
                e.preventDefault();

                var config = $(this).data("bf-config");

                if (typeof config == 'undefined' || config.length < 1) {
                    config = 'default';
                }

                $.ajax({
                    url: bf_path + '/init.php',
                    data: {
                        'bf-config': config,
                        'type': "form"
                    },
                    method: "post",
                    dataType: "html",
                    beforeSend: function(xhr) {
                        $('body').append('<div class="bf-loading"></div>');
                    },
                    success: function(xhr) {

                        $('body').append(xhr);
                        $('.bf-loading').remove();

                        $('.bf-fixed-overlay').show();

                        $(".bf-img-capcha").off();
                        bind_event_capcha(); //set refresh for click image
                        update_capcha();

                        $("form[data-bf-config]").off();
                        init_form(config);
                        bind_close_popup();
                    }
                })
            });

            $('form[data-bf-config]').off();
        }

        function bind_close_popup() {
            $(".bf-modal-close, .bf-fixed-overlay").on("click", function() {
                $(".bf-fixed-overlay").remove();
            });

            $(".bf-modal").on("click", function(e) {
                e.stopImmediatePropagation();
            });

        }

        function bind_event_capcha() {
            $("[src*='captcha.php']").on("click", function() {
                update_capcha();
            });
        }

        function update_capcha() {
            $('.bf-img-capcha').attr('src', bf_path + '/captcha.php?' + Math.random())
        }

        function init_form(config_popup) {

            $('form[data-bf-config]').on('submit', function(e) {
                e.preventDefault();

                var options = {
                    success: showResponse, // post-submit callback  
                    url: bf_path + '/init.php',
                    type: 'post',
                    dataType: 'json'
                };

                var form = $(this);

                var config = form.data("bf-config");

                if (typeof config_popup == 'undefined' || config_popup.length < 1) {
                    if (typeof config == 'undefined' || config.length < 1) {
                        config = 'default';
                    }
                } else {
                    config = config_popup;
                }

                $.post(
                    bf_path + "/init.php", {
                        'type': 'token',
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

        function showResponse(responseText, statusText, xhr, $form) {

            $('.bf-status ').remove();
            $form.before('<div class="bf-status bf-status-' + responseText['status'] + '">' + responseText['value'] + '</div>');

            if (responseText['status'] > 0) {
                $form.hide();
                update_capcha();

                setTimeout(
                    function() {
                        $('.bf-modal-close').click(); //if popup
                    }, 2000
                );

                setTimeout(
                    function() {
                        $form.show();
                        $('.bf-status').remove();
                        $form.clearForm();
                    }, 3000
                );
            }

        }

    });

})(jQuery);
