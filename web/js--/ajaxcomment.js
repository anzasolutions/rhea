$(document).ready(function() {
    $('#comment-textarea').click(function() {
        $('#comment-error').html("");
    });
    $('#comment-submit').click(function() {
        $.ajax({
            type : 'POST',
            url : $('#comment-form').attr("action"),
            dataType : 'html',
            data: {
                comment : $('#comment-textarea').val(),
                type : $('#comment-type').val(),
                id : $('#comment-id').val(),
                process : '' // this is here only because FO's require this to be set! TO BE REMOVED!!!
            },
            success : function(html){
                if (html != "")    {
                    $("#comment-list").html(html);
                    $('#comment-textarea').val("");
                } else {
                    $("#comment-error").html("Comment field cannot be empty");
                }
            },
            error : function(html){
                alert("dupa");
            }
        });
        return false;
    });
});