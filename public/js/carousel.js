function refresh() {
    // alert('ok');
    window.location.reload();
}

// sample comment
$(document).ready(function () {
    $('#SmallCarousel').carousel({
        interval: parseInt($('#carouselInterval').val()) * 1000,
        cycle: true,
        pause: false
    });
    var interval = parseInt($('#refreshInterval').val()) * 1000;
    // alert(interval);
    console.log(interval);
    window.setInterval('refresh()', interval);

    // $('#videoCarousel').on('loadedmetadata', function () {
    //     alert('ok')
    var video = $('#videoCarousel');
    if (typeof video.get(0) != 'undefined') {
        video.get(0).currentTime = parseInt($('#carouselStartTime').val());
    }

});

