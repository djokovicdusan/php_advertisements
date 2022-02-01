$(document).ready(function () {
    var table = $('#tableItems').DataTable({
        paging: false
    });

    table.on('click', 'tr', function () {

        var selectedItems = $('#allItems');
        var noOfSelectedItems = selectedItems.childElementCount - 1;
        var noviItem = $(this).children();
        selectedItems.append(`<div class='uploadDoc' style ='width:100%'><div class='col-sm-6' style ='display: inline-block'> ${noviItem[0].innerHTML} </div>
            <div class="col-sm-4" style ='display: inline-block'><input required type="number" class="form-control" name="cycles[]" placeholder="No of cycles" ></div>
                       <input type="text"  id="itemId${noOfSelectedItems}" value="${noviItem[3].innerHTML}" class="itemIds"   name="itemIds[]" hidden>

            <div class="col-sm-1"  style ='display: inline-block; cursor: pointer'><a class="btn-check"><i class="fa fa-times">x</i></a></div></div>`);
    });
});
$(document).on("click", "a.btn-check", function () {
    $(this).closest(".uploadDoc").remove();

});


