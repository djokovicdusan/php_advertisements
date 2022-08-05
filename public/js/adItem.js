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
    video.src = URL.createObjectURL(this.files[0]);
    ;

    video.preload = 'metadata';

    video.onloadedmetadata = function () {
        window.URL.revokeObjectURL(video.src);

        var duration = Math.floor(video.duration);
        console.log(duration);
        $('#duration').val(duration);

        var seconds = duration % 60;
        var minutes = Math.floor(duration / 60);

        var finalTime = minutes + ' minutes and ' + seconds + " seconds";

        var infos = $('#videoDuration');
        infos.text(finalTime);
    }


}

$(".btn-primary").on('click', function () {
    $("#uploader").append('<div class="form-group col-md-12"><input id="imageFile1" required name="images[]" data-classbutton="btn" data-input="false" type="file"></div>');
});


var progress_bar = document.getElementById('progress_bar');
var progress_bar_process = document.getElementById('progress_bar_process');
var videoFile = document.getElementById('videoFile');
var uploadedFile = document.getElementById('uploadedFileSuccess');
var inputSubmit = document.getElementById('inputSubmit');


videoFile.onchange = function () {
    // this here is copied from setFileInfoFunction
    // i dont know why it works now, but doesn't work when this method is called separately
    // maybe because of onChange conflict
    var video = document.createElement('video');
    video.src = URL.createObjectURL(this.files[0]);
    ;

    video.preload = 'metadata';

    video.onloadedmetadata = function () {
        window.URL.revokeObjectURL(video.src);

        var duration = Math.floor(video.duration);
        console.log(duration);
        $('#duration').val(duration);

        var seconds = duration % 60;
        var minutes = Math.floor(duration / 60);

        var finalTime = minutes + ' minutes and ' + seconds + " seconds";

        var infos = $('#videoDuration');
        infos.text(finalTime);
    }


    var form_data = new FormData();
    inputSubmit.disabled = true;


    // form_data.append('videoName', document.getElementsByName('videoName')[0].value);
    form_data.append('file', videoFile.files[0]);
    form_data.append('_token', document.getElementsByName('_token')[0].value);

    progress_bar.style.display = 'block';

    var ajax_request = new XMLHttpRequest();

    // ajax_request.open("POST", "{{route('adItem.upload')}}");
    ajax_request.open("POST", "adItem/upload");


    ajax_request.upload.addEventListener('progress', function (event) {

        var percent_completed = Math.round((event.loaded / event.total) * 100);

        progress_bar_process.style.width = percent_completed + '%';

        progress_bar_process.innerHTML = percent_completed + '% completed';

    });
    ajax_request.addEventListener('load', function(event){

        var file_data = JSON.parse(event.target.response);

        uploadedFile.innerHTML = '<div class="alert alert-success">Files Uploaded Successfully</div><input id="fileNameRaw" type="number" value="" hidden>';

        //"'+file_data.file_path+'"
        inputSubmit.disabled = false;


    });



    ajax_request.send(form_data);

};
