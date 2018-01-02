

var pu_ajax;
var bytes;

// start one main function with some extra's
(function ($, root, undefined) {

    'use strict';

    function get_ajax(send_task) {
        var task = (typeof send_task === 'undefined') ? 'refresh' : send_task;
        bytes = parseInt($('#bytes-pulog-screen').html());
        // ajax call
        jQuery.ajax({
            // we have set aj_data with localize to the enqueue file
            url : pu_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'pu_ajax',
                nonce  : pu_ajax.nonce,
                bytes  : bytes,
                task  : task
            },

            success : function( response ) {
                console.table(response);
                if (response.update == 'true') {
                    $('ul.pulog-screen').html(response.output);
                    $('#bytes-pulog-screen').html(response.bytes);
                }
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

        $('.hot').on('click', function(){
            var row = $(this).prop('id').replace('hot-', '');
            $('.not-' + row).toggle();
        });

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