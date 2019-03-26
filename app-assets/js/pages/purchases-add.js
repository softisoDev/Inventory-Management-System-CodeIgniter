function addProduct(e) {
    var focusedTrID = $(e).closest('tr').attr('id');
    focusedTrID     = focusedTrID.match(/\d+$/);
    focusedTrID     = parseInt(focusedTrID[0]);
    $('#focused-tr-id').val(focusedTrID);
    reInitProductsTable();
    $('#myModal').modal('show');
}

function addNewRow() {

    var lastTrID    = $('#added-items-list tbody').find('tr:last').attr('id');
    var lastNum     = lastTrID.match(/\d+$/);
    lastNum         = parseInt(lastNum[0]);
    lastNum         += 1;
    $('#last-tr-id').val(lastNum);
    $.ajax({
        url:app.host+"/purchases/add_table_row/",
        type:"POST",
        data:{newRowID:lastNum},
        success:function (data) {
            $('#added-items-list tbody:last').append(data);
            initTouchSpin();
        }
    });
}
