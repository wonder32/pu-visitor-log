

var pu_ajax;
// start one main function with some extra's
(function ($, root, undefined) {

    'use strict';

    function get_ajax() {
        var bytes = $('#bytes-pulog-screen').html();
        // ajax call
        jQuery.ajax({
            // we have set aj_data with localize to the enqueue file
            url : pu_ajax.ajax_url,
            type : 'post',
            data : {
                action : 'pu_ajax',
                nonce  : pu_ajax.nonce,
                bytes  : bytes
            },

            success : function( response ) {
                if (response.update == 'ok') {
                    $('ul.pulog-screen').html(response.output);
                    $('#bytes-pulog-screen').html(bytes);
                }
            }
        });
    }

    /*
     *      DOCUMENT READY
     */

    jQuery(document).ready(function() {

        function fader() {
            setInterval(get_ajax, 9000);
        }
        setTimeout(fader, 5000);

        $('.hot').on('click', function(){
            var row = $(this).prop('id').replace('hot-', '');
            $('.not-' + row).toggle();
        });

        $(window).resize(function () {
            $('.wrap').css('height', $(window).height() * 0.7);
            $("div.pulog-screen").scrollTop($("div.pulog-screen")[0].scrollHeight);

        });
        $(function(){ $(window).resize() });



    })

})(jQuery, this);