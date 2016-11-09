$(document).ready(function () {
    /*if (!$.pjax.efabrikov) {
        $.pjax.efabrikov = {
            queue: []
        }
    }*/
});

/******************************************************************************/
//log pjax if need
$(document).on("pjax:complete", function (k) {
    //console.dir(k.target);

    /*if ($.pjax.efabrikov.queue
            && Array.isArray($.pjax.efabrikov.queue)
            && $.pjax.efabrikov.queue.length > 0) {
        var blockId = $.pjax.efabrikov.queue.shift();
        $.pjax.reload({container: "#" + blockId});
    }*/    
    
    //var src = (location.href.indexOf('?') > 0) location.href + '&dataPjax=1' : location.href + '?dataPjax=1';
    var src = location.href;
    
    (src.indexOf('?') > 0 )? src += '&' : src += '?';
        
    src += 'completedPjaxId=' + k.target.id;
    
    $("#dataIframeContainer").html($("<iframe/>", {
         id: "dataIframe",
         style: "width:700px; height:500px; display:none;",         
         src: src,  
     }));    

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
