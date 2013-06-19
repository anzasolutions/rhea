
// jquery-ui
if ($("#message").html()) {
    $("#message").addClass("error").click(function() {
        $(this).slideUp(300);
    });
}

// remove any link with empty a href
$("a").each(function() {
    var href = $(this).attr("href");
    if (href == '') { // or anything else you want to remove...
        $(this).remove();
    }
});

// jquery.autosize.js
$(function() {
    $('textarea').autosize();
});

// jquery.lazyload.js
$(function() {
    $("img").lazyload({
        event : "scrollstop"
    });
});