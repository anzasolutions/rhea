/* Smart file input styler. Based on http://stackoverflow.com/a/3226279. */

var wrapper = $('<div/>').css({
    display : 'none'
});

var fileInput = $(':file').wrap(wrapper);

fileInput.change(function() {
    $this = $(this);
    $('#input-file').text($this.val());
});

$('#input-file').click(function() {
    fileInput.click();
}).show();