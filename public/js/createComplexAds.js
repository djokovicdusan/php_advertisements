$(document).ready(function () {
    var table = $('#tableItems').DataTable({
        paging: false
    });
    var tableMainItemModal = $('#tableItemsMainItemModal').DataTable({
        paging: false
    });

    table.on('click', 'tr', function () {

        var selectedItems = $('#allItems');
        var noOfSelectedItems = selectedItems.childElementCount - 1;
        var noviItem = $(this).children();
        selectedItems.append(`
            <div class='uploadDoc form-group' style ='width:100%'>
                <div class='col-sm-6' style ='display: inline-block'> ${noviItem[0].innerHTML} </div>
                <div class="col-sm-2" style ='display: inline-block'>
                    <input required type="number" class="form-control" name="cycles[]" placeholder="No of cycles" >
                </div>
                <div class="col-sm-2" style ='display: inline-block'>
                    <input required type="number" onmouseover="" class="form-control" name="seconds[]" placeholder="Start at second" >
                </div>
                <input type="text"  id="itemId${noOfSelectedItems}" value="${noviItem[3].innerHTML}" class="itemIds"   name="itemIds[]" hidden>

            <div class="col-sm-1"  style ='display: inline-block; cursor: pointer'><a class="btn-check"><i class="fa fa-times">x</i></a></div>
            </div>`);
    });
    tableMainItemModal.on('click', 'tr', function () {

        var selectedItem = $('#mainItem');
        var noOfSelectedItems = selectedItem.childElementCount - 1;
        var noviItem = $(this).children();
        selectedItem.empty()
        selectedItem.append(`
            <div class='uploadDoc' style ='width:100%'>
                <div class='col-sm-7' style ='display: inline-block'> ${noviItem[0].innerHTML}(${noviItem[2].innerHTML} seconds)</div>
                <div class="col-sm-2" style ='display: inline-block'>
                    <input required type="number" class="form-control" hidden value="1" name="cycles[]" placeholder="No of cycles" >
                                <input type="text"  id="itemId${noOfSelectedItems}" value="${noviItem[3].innerHTML}" class="itemIds"   name="itemIds[]" hidden>
                <input required type="number" onmouseover="" value="0" class="form-control" name="seconds[]" placeholder="Start at second" hidden >
                </div>



                 <div class="col-sm-1"  style ='display: inline-block; cursor: pointer'>
                        <a class="btn-check"><i class="fa fa-times">x</i></a>
                 </div>
            </div>`);

    });
});
$(document).on("click", "a.btn-check", function () {
    $(this).closest(".uploadDoc").remove();

});


