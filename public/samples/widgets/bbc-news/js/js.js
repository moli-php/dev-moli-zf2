$(function(){
    // Monitor ajax requests, show or hide loader image
    $(document).ajaxStart(function() {
        $('.pg_contentnews').html('<li><img id="ajax_loader_con" src="/img/ajax-loader.gif" /></li>');
        $('#result').css('height', '60px');
    });
    $(document).ajaxComplete(function() {
        $('#result').css('height', '350px');
    });

    $('#categories').change(function(){
        var name = $(this).val();
        $.ajax({
            url : '/widgets-api/bbc-news',
            type : 'post',
            data : {
                name:name
            },
            dataType : 'json',
            success : function(data){
                $('.pg_contentnews').html("");
                 
                $.get('/widgets/bbc-news-item', function(bbc_template){
                    $.each(data, function(k,feed){
                        $('.pg_contentnews').append(tplawesome(bbc_template,[{
                            "title":feed.title,
                            "link":feed.link,
                            "description":feed.description,
                            "date":feed.date,
                            "thumbnail":feed.thumbnail
                        }]));
                    });
                     
                });
               
            }
        });
    })

});

function tplawesome(e,t){
    res=e;
    for(var n=0;n<t.length;n++){
        res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){
            return t[n][r]
        })
    }
    return res
}

