function refresh() {
    // alert('ok');
    window.location.reload();
}

// sample comment
$(document).ready(function () {
    $('#SmallCarousel').carousel({
        interval: $('#carouselInterval').val() * 1000, // zameniti sa Math.round()
        cycle: true,
        pause: false
    });
    var interval = $('#refreshInterval').val() * 1000; // mozda zameniti sa Math.round()
    var intervalInMilliSeconds = $('#refreshIntervalMilliSeconds').val();
    // alert(interval);
    // window.setInterval('refresh()', interval);
    window.setInterval('refresh()', intervalInMilliSeconds);


    // $('#videoCarousel').on('loadedmetadata', function () {
    //     alert('ok')
    var video = $('#videoCarousel');

    // console.log(video);
    if (typeof video.get(0) != 'undefined') {
        // video.get(0).currentTime = Math.round($('#carouselStartTime').val()); // mozda zameniti sa Math.round()
        video.get(0).currentTime = Math.round(($('#carouselStartTimeMilliSeconds').val() / 1000).toFixed(3)); // mozda zameniti sa Math.round()
    }
    var time = new Date().getSeconds();

    // if($('#adItemName').val().localeCompare('defaultAd')){
    //     console.log("seconds by sistem clock:" + time);
    //     window.setInterval('refresh()', (60-time)*1000);
    // }
    // else{
    //     window.setInterval('refresh()', interval);
    // }

     // document.getElementById("videoCarousel").controls=false;
    // document.getElementById("videoCarousel").style.width = window.innerWidth;
    // document.getElementById("videoCarousel").style.height = window.innerHeight;

     document.getElementById("videoCarousel").requestFullscreen();


    // videoCarousel.onloadeddata = function () {


    //
    //     console.log("ucitan video")
    //     $.ajax({
    //         method: 'GET',
    //         url: window.location,
    //         success: function (data) {
    //             console.log(data.refreshInterval);
    //             if (typeof video.get(0) != 'undefined') {
    //                 video.get(0).currentTime = Math.round(data.adItemStartTime); // mozda zameniti sa Math.round()
    //             }
    //             window.setInterval('refresh()', data.refreshInterval);
    //
    //         }
    //     });
    //
    // }

});

