var gapikey = 'AIzaSyDGCHYjptg0fLVCqwUPTW88dnTR6qwAvmU';

$(function() {
    
    // call fancybox pluggin
    $(".fancyboxIframe").fancybox({
        maxWidth    : 900,
        maxHeight    : 600,
        fitToView    : false,
        width        : '90%',
        height        : '90%',
        autoSize    : false,
        closeClick    : false,
        openEffect    : 'none',
        closeEffect    : 'none',
        iframe: {
            scrolling : 'auto',
            preload   : true
        }
    });
    
    $('#search-form').submit( function(e) {
        e.preventDefault();
    });
});

function searchYoutube() {
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val(); 
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            type: 'video',
            key: gapikey
        }, function(data) {
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html(''); // hide loading
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });
}

// Next page function
function nextPage() {
    var token = $('#next-button').data('token');
    var q = $('#next-button').data('query');
    
    
   // clear 
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val();
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            pageToken: token,
            type: 'video',
            key: gapikey
        }, function(data) {
            
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html('');
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            
            var buttons = getButtons(prevPageToken, nextPageToken);
            
            // Display buttons
            $('#buttons').append(buttons);
        });    
}

// Previous page function
function prevPage() {
    var token = $('#prev-button').data('token');
    var q = $('#prev-button').data('query');
    
    
   // clear 
    $('#results').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
    $('#buttons').html('');
    
    // get form input
    q = $('#search').val();  // this probably shouldn't be created as a global
    
    // run get request on API
    $.get(
        "https://www.googleapis.com/youtube/v3/search", {
            part: 'snippet, id',
            q: q,
            pageToken: token,
            type: 'video',
            key: gapikey
        }, function(data) {
            
            var nextPageToken = data.nextPageToken;
            var prevPageToken = data.prevPageToken;
            
            // Log data
            console.log(data);
            $('#results').html('');
            $.each(data.items, function(i, item) {
                
                // Get Output
                var output = getOutput(item);
                
                // display results
                $('#results').append(output);
            });
            var buttons = getButtons(prevPageToken, nextPageToken);
            // Display buttons
            $('#buttons').append(buttons);
        });    
}

// Build output
function getOutput(item) {
    var videoID = item.id.videoId;
    var title = item.snippet.title;
    var description = item.snippet.description;
    var thumb = item.snippet.thumbnails.high.url;
    var channelTitle = item.snippet.channelTitle;
    var videoDate = item.snippet.publishedAt;
    
    // Build output string
    var output =        '<div class="col-md-6">' +
                            '<img src="' + thumb + '" class="img-responsive thumbnail" >' +
                        '</div>' +
                        '<div class="input-group col-md-6">' +
                            '<h3><a data-fancybox-type="iframe" class="fancyboxIframe" href="http://youtube.com/embed/' + videoID + '?rel=0">' + title + '</a></h3>' +
                            '<small>By <span class="channel">' + channelTitle + '</span> on ' + videoDate + '</small>' +
                            '<p>' + description + '</p>' +
                        '</div>' +
                    '<div class="clearfix"></div>';
    return output;
}

function getButtons(prevPageToken, nextPageToken) {
    if(!prevPageToken) {
        var btnoutput =     '<ul class="pagination">' +
                                '<li><a href="javascript:;"  id="next-button" class="paging-button" data-token="' + nextPageToken + '" data-query="' + q + '"' +
                                    'onclick = "nextPage();">Next &raquo;</a></li>' +
                            '</ul>';
    } else {
        var btnoutput =     '<ul class="pagination">' +
                                '<li><a href="javascript:;" id="prev-button" class="paging-button" data-token="' + prevPageToken + '" data-query="' + q + '"' +
                                    'onclick = "prevPage();">&laquo; Previous</a></li>' +            
                                '<li><a href="javascript:;" id="next-button" class="paging-button" data-token="' + nextPageToken + '" data-query="' + q + '"' +
                                    'onclick = "nextPage();">Next &raquo;</a></li>' +
                            '</ul>';        
    }
    
    return btnoutput;
}