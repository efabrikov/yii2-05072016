$(document).on("pjax:complete", function (k) {
    //update other pjax block?
});

/*$("a").click(function() {
 console.log("click to url: " + $(this).attr("href"));
 });*/


/*$(document).on('click', 'a', function () {
 console.log("click to url: " + $(this).attr("href"));
 })*/

function reloadIframe(url) {
    $("#iframeContainer").html($("<iframe/>", {
        id: "myIframe",
        src: url + "&t=" + Date.now(),
        frameborder: "0",
        marginheight: "0",
        marginwidth: "0",
        style: "background: transparent; width: 100%;"
    }));

}

function updateIframeEvents() {
    $("#myIframe").load(function () {
        var iframeSrc = $(this).attr("src");
        var iframe = document.getElementById("myIframe");
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
            if (iframeSrc != iframe.contentWindow.location.href) {
                console.log("iframe updated, so change browser url");

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


    });
}

function resizeIframe() {
    var iframe = $('#myIframe', parent.document.body);
    iframe.height($(document.body).height());
}

function updatePage(url) {
    console.log("updatePage()");

    var iframe = document.getElementById("myIframe");
    var iframeHref = (iframe) ? iframe.contentWindow.location.href : '';
    var fixedIframeHref = (iframeHref) ? iframe.contentWindow.location.origin + iframe.contentWindow.location.pathname + iframe.contentWindow.location.search.replace(/\//g, "%2F") : '';

    //var fixedUrl = iframe.contentWindow.location.pathname + iframe.contentWindow.location.search.replace(/\//g, "%2F");
    //reload iframe if url different
    if (!iframeHref || (url != iframeHref && url != fixedIframeHref)) {
        console.log("reloadIframe()");

        console.log("url: " + url);
        console.log("iframeHref: " + iframeHref);

        reloadIframe(url);

        updateIframeEvents(url);

        resizeIframe();
    }
}


var oldURL = window.location.href;

function checkURLchange(currentURL) {
    //console.log(Date.now());
    if (currentURL != oldURL) {
        oldURL = currentURL;
        updatePage(currentURL);
    }
}

setInterval(function () {
    checkURLchange(window.location.href);
}, 1000);
