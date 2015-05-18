
// init gmap
var initialize = function() {
    var mapOptions = {
        center: new google.maps.LatLng(latitude, longitude),
        zoom: 10
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    initTweets(map, tweetList);
}

// init tweets markers
var initTweets = function(map, tweetlist) {
    var i = 0;

    // foreach tweet, we add a marker in gmap
    for (i; i < tweetlist.length; i++) {
        var tweet = tweetlist[i];
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(tweet[3], tweet[4]),
            map: map,
            icon: tweet[1],
            content: tweet[2],
            title: tweet[0]
        });

        // show the content onclick
        var info = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, "click", function () {
            info.setContent(this.content);
            info.open(map, this);
        });
    }
}

google.maps.event.addDomListener(window, 'load', initialize);

//onclick on submit button, we redirect the user
$('#submitLocation').click(function() {
    if($("#inputLocation").val()) {
        window.location.href = searchUrl + '/' + $("#inputLocation").val();
    }
});