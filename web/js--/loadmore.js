
$(document).ready(function() {
    $('#load-button').click(function() {
        $('#load-button').hide();
        $('#load-more').append('<img id="loader" src="../web/images/ajax-loader.gif"></img>');
        $.ajax({
            type : 'POST',
            url : $('#loadMoreForm').attr("action"),
            dataType : 'html',
            data: {
                last : $('#loadMoreCount').val(),
                process : '' // this is here only because FO's require this to be set! TO BE REMOVED!!!
            },
            success : function(html) {
                if (html != "")    {
                    $('#media-wall').append(html);
                    $('#loadMoreCount').val(parseInt($('#loadMoreCount').val())+parseInt($('#loadMoreRange').val()));
                } else {
                    $("#comment-error").html("Comment field cannot be empty");
                }
                $('#loader').remove();
                $('#load-button').show();
            },
            error : function(html){
                alert("dupa");
            }
        });
        return false;
    });
});