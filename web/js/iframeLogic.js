$(document).on("pjax:complete", function (k) {
    //update other pjax block?
});

function reloadIframe(url) {
    $("#iframeContainer").html($("<iframe/>", {
        id: "myIframe",
        src: url + "&t=" + Date.now(),
        frameborder: "0",
        marginheight: "0",
        marginwidth: "0",
        style: "background: transparent; width: 100%; height: 800px"
    }));

}

function updateIframeEvents() {
    $("#myIframe").load(function () {
        var iframeSrc = $(this).attr("src");
        var iframeAbsoluteUrl = $("#myIframe").contents().find("#tmpData").attr("data-absoluteUrl");
        var iframeAbsolutePath = iframeAbsoluteUrl.replace("http://", '').replace("http://", '').replace(/.+?\//, '/');

        /*console.log("iframeSrc: " + iframeSrc);
        console.log("iframeAbsoluteUrl: " + iframeAbsoluteUrl);
        console.log("iframeAbsolutePath: " + iframeAbsolutePath);*/

        //click on menu after php GET redirect
        if (iframeSrc != iframeAbsoluteUrl) {
            console.log("iframe updated, so redirect to new url");
            $("#mainMenu").find("a[href=\"" + iframeAbsolutePath + "\"]").click();
        }

    });
}

function updatePage(url) {
    console.log("updatePage()");
    var iframeAbsoluteUrl = $("#myIframe").contents().find("#tmpData").attr("data-absoluteUrl");

    //reload iframe if url different
    if (iframeAbsoluteUrl != url) {
        console.log("reloadIframe() " + url);
        reloadIframe(url);
        
        updateIframeEvents();
    }
}


var oldURL = window.location.href;

function checkURLchange(currentURL) {
    //console.log(Date.now());
    if (currentURL != oldURL) {
        updatePage(currentURL);
        oldURL = currentURL;
    }
}

setInterval(function () {
    checkURLchange(window.location.href);
}, 1000);
