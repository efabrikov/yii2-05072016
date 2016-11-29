$(document).ready(function () {
    $.pjax.defaults.timeout = 5000;
    
    if (!$.pjax.efabrikov) {
        $.pjax.efabrikov = {
            //list of pjax block that must be reloaded
            queue: [],

            reloadBlocks: function () {
                console.log($.pjax.efabrikov.queue);

                if ($.pjax.efabrikov.queue
                        && Array.isArray($.pjax.efabrikov.queue)
                        && $.pjax.efabrikov.queue.length > 0) {
                    var blockId = $.pjax.efabrikov.queue.shift();

                    var prefix = '?';
                    if ((window.location.href).indexOf('?') > 0) {
                        prefix = '&';
                    }

                    $.pjax.reload({
                        container: "#" + blockId,
                        url: window.location.href + prefix + "isPjaxReload=1",
                        replace: false
                    });
                }
            }
        }
    }
});

/******************************************************************************/
//log pjax if need
$(document).on("pjax:complete", function (k) {
    //console.dir(k.target);    

    $.pjax.efabrikov.reloadBlocks();
});

$(document).on("pjax:start", function (k) {

});

/******************************************************************************/
//animate pjax load if need
$(document).on("pjax:start", function (k) {
    //console.dir('pjax:start:'+k.target.id);

    //$(k.target).fadeOut(100);
    //$(k.target).hide();

    $(k.target).find("a").css('cursor', 'progress');
});

$(document).on("pjax:end", function (k) {
    //console.dir('pjax:end:'+k.target.id);

    //$(k.target).fadeIn(500);
});
/******************************************************************************/

//alert("first load");
