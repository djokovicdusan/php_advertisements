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
    // var interval = parseInt($('#refreshInterval').val()) * 1000;
    // // alert(interval);
    // console.log(interval);
    // window.setInterval('refresh()', interval);

    // $('#videoCarousel').on('loadedmetadata', function () {
    //     alert('ok')


});
