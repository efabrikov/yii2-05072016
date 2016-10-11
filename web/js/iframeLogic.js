//for pjax main menu
$(document).on("pjax:complete", function (k) {    
    //console.dir(k.target.id);
    var iframe = document.getElementById("myIframe2");
    var isMainMenuEvent =  ('mainMenuPjax' == k.target.id)? true : false;
    
    //menu click event on first load
    if (isMainMenuEvent && !iframe) {
        //console.log("reload #contentPjax");
        $.pjax.reload('#contentPjax');
    }
    
    //menu click event after iframe reloaded
    if (isMainMenuEvent && iframe && isIframeReadable(iframe) && isIframeReloaded(iframe)) {
        //console.log("reload #contentPjax");
        $.pjax.reload('#contentPjax');
    }
    
    //alert(isIframeReloaded());
    

});

//onLoad iframe event
function processIframeLoad() {
    console.log("processIframeLoad()");

    var iframe = document.getElementById("myIframe2");

    if (iframe) {
        resizeIframe(iframe);
        bindIframeEvents(iframe);
    }
}

function bindIframeEvents(iframe) {
    console.log("bindIframeEvents()");
    var iframeReadable = true;

    try {
        var tmpHref = iframe.contentWindow.location.href;
    } catch (e) {
        //external domain or other errors
        iframeReadable = false;
    }

    if (iframeReadable) {
        console.log("internal url: " + iframe.contentWindow.location.href);

        //click on menu after php GET redirect
        if (location.href != iframe.contentWindow.location.href) {
            console.log("iframe updated, so change browser url");
            console.log(location.href + ' != ' + iframe.contentWindow.location.href);

            var menuLink = $("#mainMenu").find("a[href=\""
                    + iframe.contentWindow.location.pathname
                    + iframe.contentWindow.location.search
                    + "\"]")[0];

            if (!menuLink) {
                menuLink = $("#mainMenu").find("a[href=\""
                        + iframe.contentWindow.location.pathname
                        + iframe.contentWindow.location.search.replace(/\//g, "%2F")
                        + "\"]")[0];
            }

            if (!menuLink) {
                $("#mainMenu").append('<a id="menuHidenLink"'
                        + ' style="display:none;"'
                        + ' href="' + iframe.contentWindow.location.href + '"'
                        + ' </a>');
                menuLink = $("#menuHidenLink");
            }

            if (menuLink) {
                menuLink.click();
            }
            else {
                console.log("can't find menu link");
            }
        }

        //when click to external url
        $(iframe.contentWindow.document).on('click', 'a', function (event) {
            console.log('click link from iframe: ' + $(this).attr("href"));
            var linkHost = $(this).attr("href")
                    .replace("http://", '')
                    .replace("http://", '')
                    .replace(/\/.+/, '')
                    .replace(/\?.+/, '')
                    .replace(/\#.+/, '')
                    .replace(/www\./, '');

            if (linkHost && document.location.host != linkHost && !$(this).attr('target')) {
                console.log(document.location.host + " != " + linkHost)
                console.log('redirect to external url: ' + $(this).attr("href"));
                document.location.href = $(this).attr("href");
            }

        });
    }
    else {
        //console.log("external url");
    }



}

function resizeIframe(iframe) {
    console.log("resizeIframe()");
    var iframe2 = $('#myIframe2', parent.document.body);
    
    console.log('iframe width: ' + iframe2.width());
    console.log('iframe height: ' + iframe2.height());
    console.log('iframe parent width: ' + iframe2.parent().width());
    
    iframe2.height($(document.body).height());    
    //fix for iframe reload.
    $('#contentPjax').css('min-height', $(document.body).height() + 'px');
    //slideDown,show scroll
    iframe2.slideDown('slow', function() {
        iframe2.css('overflow','scroll');
        iframe2.contents().find('body').css('overflow', 'auto');
    });
    
    
}


function isIframeReloaded(iframe) {
    if (location.href != iframe.contentWindow.location.href && location.href.replace('%2F', '/') != iframe.contentWindow.location.href) {
        //console.log(location.href + ' != ' + iframe.contentWindow.location.href);
        return true;
    }

    return false;

}

function isIframeReadable(iframe) {

    var iframeReadable = true;

    try {
        var tmpHref = iframe.contentWindow.location.href;
    } catch (e) {
        //external domain or other errors
        iframeReadable = false;
    }
    
    return iframeReadable;
}