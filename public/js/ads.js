/* Start editing user */
var id;
// var isAdmin = 0;
// isAdmin = $("#admin").val();
// console.log(isAdmin);

// $(window).on("load", function() {
//     if(location.href.indexOf("ads/create") != -1){
//
//     }
//     else {
//         // Set image
//         // alert($("#url").val());
//         // $("#imageFile1").attr("src", $("#url").val() + "/" + $("#logo").val());
//         // $("#uploadImageFile").attr("src", $("#url").val() + "/" + $("#logo").val());
//         document.getElementById('results').innerHTML = '<img weight="300" height="220" src="'+$("#url").val() + "/" + $("#logo").val()+'"/>';
//     }
// });

// if(isAdmin == 1) {
// $(function () {
//     // alert('ucitano!')
//     $("#goToCreate").click(function () {
//         $("input[name^=_method]").val("GET");
//         $("#userForm").attr("action", window.location + "/create");
//         $("#userButton").click();
//     });
// });

// }else{
//     $("#goToCreate").hide();
// }

// // if(isAdmin == 1) {
//     $(".single").click(function () {
//         // if(!$(event.target).hasClass('not_clickable')) {
//         id = $(this).attr('id').split("_").pop();
//         console.log(id);
//         $("input[name^=_method]").val("GET");
//         $("#userForm").attr("action", window.location + "/" + id);
//         $("#userButton").click();
//         // }
//     });
// }else{
//
// }

// $("#edit").click(function() {
//     $("input[name^=_method]").val("GET");
//     $("#userForm").attr("action", window.location + "/edit");
//     $("#userButton").click();
// });

// $("#edit2").click(function() {
//     $("input[name^=_method]").val("GET");
//     $("#userForm").attr("action", window.location + "/edit");
//     $("#userButton").click();
// });

$("#delete").click(function () {
    $("input[name^=_method]").val("DELETE");
    $("#userForm").attr("action", window.location);
    $("#userButton").click();
});

// $(".editnote").click(function() {
//     var user_id = $("#user_id").val();
//     id = $(this).attr('id').split("_").pop();
//     $("input[name^=_method]").val("GET");
//     $("#userForm").attr("action", window.location + "/../../notes/" + id + "/edit/" + user_id);
//     $("#userButton").click();
// });

// $(".deletenote").click(function() {
//     var user_id = $("#user_id").val();
//     id = $(this).attr('id').split("_").pop();
//     $("input[name^=_method]").val("DELETE");
//     $("#userForm").attr("action", window.location + "/../../notes/" + id + "/" + user_id);
//     $("#userButton").click();
// });

// $(".deletefile").click(function() {
//     var user_id = $("#user_id").val();
//     id = $(this).attr('id').split("_").pop();
//     $("input[name^=_method]").val("DELETE");
//     $("#userForm").attr("action", window.location + "/../files/" + id + "/" + user_id);
//     $("#userButton").click();
// });

$("#addNote").click(function () {
    var user_id = $("#user_id").val();
    $("input[name^=_method]").val("GET");
    $("#userForm").attr("action", window.location + "/../../notes/create/" + user_id);
    $("#userButton").click();
});

$("#doCashOut").click(function () {
    var user_token = $("#user_token").val();
    var num_of_plaquettes = $("#plaquettes").val();
    // console.log(num_of_plaquettes);
    if (num_of_plaquettes > 0) {
        $("input[name^=_method]").val("GET");
        $("#userForm").attr("action", window.location + "/../makeCashOut/" + user_token + "/" + num_of_plaquettes);
        $("#userButton").click();
    }
});

$("#doLoginQr").click(function () {
    var user_id = $("#user_id").val();
    $("input[name^=_method]").val("GET");
    $("#userForm").attr("action", window.location + "/../makeLoginQr/" + user_id);
    $("#userButton").click();
});

$("#openImage").click(function () {
    var user_id = $("#user_id").val();
    $("input[name^=_method]").val("GET");
    $("#userForm").attr("action", window.location + "/../makeLoginQr/" + user_id);
    $("#userButton").click();
});

$("#btnForGenerate").click(function () {
    console.log("aaa");
    $.ajax({
        url: "getDummyEmail",
        cache: false
    }).done(function (html) {
        console.log(html);
        $('#email').val(html);
    });
});


// $(function () {
//     $('#datetimepicker1').datepicker({
//         autoclose: 1,
//         todayHighlight: 1,
//         format: 'dd.mm.yyyy',
//     })
//         .on("changeDate", function(e) {
//             // console.log(e);
//             var date = e.date;
//             startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
//             endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
//             //$('#weekpicker').datepicker("setDate", startDate);
//             // $('#weekpicker').datepicker('update', startDate);
//             $('#date_value').val(startDate.getFullYear() + '-' + (startDate.getMonth() + 1) + '-' +  startDate.getDate() + ' : ' + endDate.getFullYear() + '-' + (endDate.getMonth() + 1) + '-' +  endDate.getDate());
//             $("#apply").click();
//         });
// });

var table = $(".js-dataTable-full-pagination").DataTable({
    aaSorting: [],
    pagingType: "full_numbers",
    pageLength: 20,
    lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
    autoWidth: 1,
    scrollX: false
});
table.on('click', 'tbody tr', function () {
    // alert('kliknut je red !');
    var noviItem = $(this).children();
    // if(noviItem[0].innerHTML=="ID"){
    //     return;
    // }

    // alert(noviItem[2].innerHTML);
    $('#inputStartTime').val(noviItem[2].innerHTML);

    $form = $('#formAdDetail');
    $form.submit();
});


// var alphabet = $('<div class="alphabet col-sm-1"/>');

// $('<button class="clear active"/>')
//     .data( 'letter', '' )
//     .html( 'All' )
//     .appendTo( alphabet );

// for ( var i=0 ; i<26 ; i++ ) {
//     var letter = String.fromCharCode( 65 + i );
//
//     $('<button/>')
//         .data( 'letter', letter )
//         .html( letter )
//         .appendTo( alphabet );
// }

// alphabet.insertAfter( $(".block") );

// var _alphabetSearch;

// $.fn.dataTable.ext.search.push( function ( settings, searchData ) {
//     if ( ! _alphabetSearch ) { // No search term - all results shown
//         return true;
//     }
//
//     if ( searchData[1].charAt(0).toUpperCase() === _alphabetSearch.toUpperCase() ) {
//         return true;
//     }
//
//     return false;
// } );

// alphabet.on( 'click', 'button', function () {
//     alphabet.find( '.active' ).removeClass( 'active' );
//     $(this).addClass( 'active' );
//
//     _alphabetSearch = $(this).data('letter');
//     table.draw();
// } );

