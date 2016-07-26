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
    tinymce.init({
        selector: '#description'
    });
});