$(function () {
    typeCheckChanged();
    var infos = document.getElementById('videoDuration');
    infos.textContent = "";
});

function typeCheckChanged() {
    if ($('#videoButton').is(':checked')) {
        //video radio button is checked
        $('#videoWrapper').show()
        $('#slideshowWrapper').hide();

    } else if ($('#slideshowButton').is(':checked')) {
        //photo radio button is
        $("#duration").val("");
        $('#slideshowWrapper').show();
        $('#videoWrapper').hide();
    }
}

window.URL = window.URL || window.webkitURL;

document.getElementById('videoFile').onchange = setFileInfo;

function setFileInfo() {

    var video = document.createElement('video');
    video.src = URL.createObjectURL(this.files[0]);;

    video.preload = 'metadata';

    video.onloadedmetadata = function () {
        window.URL.revokeObjectURL(video.src);

        var duration = Math.floor(video.duration);
        $('#duration').val(duration);

        var seconds = duration % 60;
        var minutes = Math.floor(duration / 60);

        var finalTime = minutes+' minutes and '+ seconds + " seconds";

        var infos = $('#videoDuration');
        infos.text(finalTime);
    }


}
$(".btn-primary").on('click',function(){
    $("#uploader").append('<div class="form-group"><input id="imageFile1" required name="images[]" data-classbutton="btn" data-input="false" type="file"></div>');
});
