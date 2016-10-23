$(document).ready(function() {
        return $("[data-toggle=tooltip]").tooltip(), $("[data-toggle=popover]").popover(), $(".dropdown-toggle").dropdown(), $(".dropdown.hover").hover(function() {
            return $(this).find(".dropdown-menu").stop(!0, !0).fadeIn()
        }, function() {
            return $(this).find(".dropdown-menu").stop(!0, !0).delay(100).fadeOut()
        }), $("#toggle").click(function() {
            return $("#dock .launcher a").toggle(), $("#dock li.launcher").each(function() {
                return $(this).find(".dropdown-menu").css("top", $(this).position().top + 33)
            })
        }), $("[data-toggle=toolbar-tooltip]").tooltip({
            placement: "bottom"
        }), $(".knob").knob();
});

$(document).ready(function(){   
    // Подключаем редактор
     var editor = tinymce.init({
         selector: '#description'
    });


    window.downloadFile = function (sUrl) {
        //iOS devices do not support downloading. We have to inform user about this.
        if (/(iP)/g.test(navigator.userAgent)) {
            alert('Your device does not support files downloading. Please try again in desktop browser.');
            return false;
        }

        //If in Chrome or Safari - download via virtual link click
        if (window.downloadFile.isChrome || window.downloadFile.isSafari) {
            //Creating new link node.
            var link = document.createElement('a');
            link.href = sUrl;

            if (link.download !== undefined) {
                var fileName = sUrl.substring(sUrl.lastIndexOf('/') + 1, sUrl.length);
                link.download = fileName;
            }

            //Dispatching click event.
            if (document.createEvent) {
                var e = document.createEvent('MouseEvents');
                e.initEvent('click', true, true);
                link.dispatchEvent(e);
                return true;
            }
        }

        // Force file download (whether supported by server).
        if (sUrl.indexOf('?') === -1) {
            sUrl += '?download';
        }

        window.open(sUrl, '_self');
        return true;
    }
    window.downloadFile.isChrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    window.downloadFile.isSafari = navigator.userAgent.toLowerCase().indexOf('safari') > -1;
});