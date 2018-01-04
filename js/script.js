

var pu_ajax;
var bytes;
var intVal;

// start one main function with some extra's
(function ($, root, undefined) {

    'use strict';

    function get_ajax(send_task) {
        var task = (typeof send_task === 'undefined') ? 'refresh' : send_task;
        var bytes = parseInt($('#bytes-pulog-screen').html());
        var start = new Date();
        // ajax call
        jQuery.ajax({
            // we have set aj_data with localize to the enqueue file
            url : pu_ajax.ajax_url,
            type : 'post',
            data : {
                beforeSend: function()
                {
                    $('.pu-added').remove('.pu-added');
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
                var time = Math.floor((new Date() - start) / 1000);
                $('.pu-added').remove('.pu-added');
                if (response.update == 'true') {
                    $('ul.pulog-screen').html(response.output);
                    $('#bytes-pulog-screen').html(response.bytes);
                } else {
                    $('div.pulog-screen').append('<span class="pu-added">No new results ' + time + ' seconds</span>');
                }
                $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);
            },

            error : function () {
                console.log('error', 'an error during request');
            }

        });
    }

    function refresh() {
        var status = $('#pu-log-refresh-status');
        var button = $('.pu-log-refresh span');
        if (status.html() === 'off') {
            intVal = setInterval(get_ajax, 9000);
            status.html('on');
            button.html('Refresh activated');
            button.removeClass('deactivated');
        } else {
            clearInterval(intVal);
            status.html('off');
            button.html('Refresh deactivated');
            button.addClass('deactivated');
        }
    }

    /*
     *      DOCUMENT READY
     */

    jQuery(document).ready(function() {


        setTimeout(refresh, 5000);

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

        $('.pu-log-refresh span').on('click', function(){
            refresh();
        });


        $(window).resize(function () {
            $('.wrap').css('height', $(window).height() * 0.7);
            $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);

        });

        $(function(){ $(window).resize() });



    })

})(jQuery, this);