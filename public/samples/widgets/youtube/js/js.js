$(function() {
    $('#search_btn').click(function(e) {
        e.preventDefault();
        var search = $('#search').val();
        if(search.length == 0) return false;
		
        $('#result').html("");
			
        var request = gapi.client.youtube.search.list({
            part: 'snippet',
            type : 'video',
            q : encodeURIComponent(search).replace(/%20/g, "+"),
            maxResult : 10,
            order : 'viewCount'
			
        });
		
        request.execute(function(response){
            var results = response.result;
            $.get('widgets/youtube-item', function(youtube_template){
                $.each(results.items, function(k,item){

                    $('#result').append(tplawesome(youtube_template,[{
                        "title":item.snippet.title, 
                        "videoid":item.id.videoId
                    }]));
                });
                
            });
        });
		
        $('#result').css('height', '420px');
		
        return false;
		
		
    });
});
function init() {
    gapi.client.setApiKey('AIzaSyC81N3rIWyQmKT5Gy_e3ot9bq2nNRqBCxM');
    gapi.client.load('youtube', 'v3', function() {
        });
}
function tplawesome(e,t){
    res=e;
    for(var n=0;n<t.length;n++){
        res=res.replace(/\{\{(.*?)\}\}/g,function(e,r){
            return t[n][r]
        })
    }
    return res
}