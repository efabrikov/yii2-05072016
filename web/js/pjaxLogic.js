$(document).ready(function () {
    if (!$.pjax.efabrikov) {
     $.pjax.efabrikov = {
     queue: []
     }
     }
});

/******************************************************************************/
//log pjax if need
$(document).on("pjax:complete", function (k) {
    //console.dir(k.target);

    if ($.pjax.efabrikov.queue
            && Array.isArray($.pjax.efabrikov.queue)
            && $.pjax.efabrikov.queue.length > 0) {
        var blockId = $.pjax.efabrikov.queue.shift();
        $.pjax.reload({container: "#" + blockId});
    }
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
