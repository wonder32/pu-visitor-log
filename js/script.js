

var pu_ajax;
var bytes;

// start one main function with some extra's
(function ($, root, undefined) {

    'use strict';

    function get_ajax(send_task) {
        var task = (typeof send_task === 'undefined') ? 'refresh' : send_task;
        var bytes = parseInt($('#bytes-pulog-screen').html());
        // ajax call
        jQuery.ajax({
            // we have set aj_data with localize to the enqueue file
            url : pu_ajax.ajax_url,
            type : 'post',
            data : {
                beforeSend: function()
                {
                    $('.pu-added').remove('.pu-added');
                    $('ul.pulog-screen').append('<li class="pu-added"><span class="blinking-cursor">.</span><span class="blinking-cursor2">.</span></li>');
                    $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);
                },
                action : 'pu_ajax',
                nonce  : pu_ajax.nonce,
                bytes  : bytes,
                task  : task
            },

            success : function( response ) {
                console.table(response);
                $('.pu-added').remove('.pu-added');
                if (response.update == 'true') {
                    $('ul.pulog-screen').html(response.output);
                    $('#bytes-pulog-screen').html(response.bytes);
                } else {
                    $('div.pulog-screen').append('<span class="pu-added">No new results</span>');
                }
                $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);
            },

            error : function () {
                console.log('error', 'an error during request');
            }

        });
    }

    function fader() {
        setInterval(get_ajax, 9000);
    }

    /*
     *      DOCUMENT READY
     */

    jQuery(document).ready(function() {


        setTimeout(fader, 5000);

        // stachtrace toggle
        var screenList = $('ul.pulog-screen');
        screenList.delegate('.hot', 'click', function(){
            var row = $(this).prop('id').replace('hot-', '');
            $('.not-' + row).toggle();
        });

        // clean wp-debug.log
        $('.pu-log-size span').on('click', function(){
            get_ajax('delete');
        });


        $(window).resize(function () {
            $('.wrap').css('height', $(window).height() * 0.7);
            $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);

        });

        $(function(){ $(window).resize() });



    })

})(jQuery, this);