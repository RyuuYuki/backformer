//jQuery.noConflict();

(function($) {
    $(function() {

                function listener(event) {
            if( event.origin != 'http://learn.javascript.ru') { 
                // что-то прислали с чужого домена - проигнорируем..    
                //return;
            }

            var d = event.data;

            if(parseInt(d) === 1) {

                $.fancybox.update();  
                 console.log('update');
             } else {

            d = d.split(',');

                window.gow = d[0];
                window.goh = d[1];


                       $.fancybox({
                    type: 'iframe',
                    autoSize: false,
                    preload   : true,
                    beforeLoad: function() {
  
                        this.href = '/backformer2/configs/default/index.html';
 
                         console.log(d[0]+'+'+d[1]);
                        this.width = d[0];
                        this.height = d[1]; 
                    },
                   beforeShow  :  function() {       
                    }
                });
             }


 
        }

        if (window.addEventListener){
            window.addEventListener("message", listener, false);
        } else {
            window.attachEvent("onmessage", listener);
        }



$('#msg').html('<iframe name="xxx" id="xxx" src="http://127.0.0.1/backformer2/configs/default/index.html" frameborder="0" marginheight="0" marginwidth="0"></iframe>');

 //      var iframe = $('#iframe');
 //     iframe[0].contentWindow.postMessage(sendObject, document.location);


    $( ".btn-popup" ).on( "click", function() {
         var win = frames.xxx;
            win.postMessage("Привет!", "*");


      
    });

 

        window.gox = function () {
            alert(window.gow);
        };

        if (typeof $(".bf-run").fancybox == 'function') {
            $(".bf-run")
                .fancybox({
                    type: 'iframe',
                    autoSize: false,
                    preload   : true,
                    beforeLoad: function() {
                        var config = parseInt(this.element.data('bf-config'));
 
                        if(isNaN(config)) {
                        	config = 'default';
                        } 
 
                        this.href = '/backformer2/configs/'+config+'/index.html#'+config;


                          var win = frames.xxx;
            win.postMessage("Привет!", "*"); 

                         console.log(window.gow+'+'+window.goh);
                        this.width = window.gow;
                        this.height = window.goh; 
                    },
                   beforeShow  :  function() {
      
      
                           
                    }
                });
        }

 
             
 
        

    });
})(jQuery);
