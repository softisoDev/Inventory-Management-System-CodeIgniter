function addProduct(e) {
    var focusedTrID = $(e).closest('tr').attr('id');
    focusedTrID     = focusedTrID.match(/\d+$/);
    focusedTrID     = parseInt(focusedTrID[0]);
    $('#focused-tr-id').val(focusedTrID);
    /*reInitProductsTable();*/
    var warehouseID = $('#warehouse').val();
    if(warehouseID==""){
        runSweetAlert("Anbar Seçilməyib!","Zəhmət olmasa məhsulu əlavə edəcəyiniz anbarı seçin","warning");
    }
    else {
        destroyProductsTable();
        initProductsModal(warehouseID);
        $('#myModal').modal('show');
    }

}

function addNewRow() {

    var lastTrID    = $('#added-items-list tbody').find('tr:last').attr('id');
    var lastNum     = lastTrID.match(/\d+$/);
    lastNum         = parseInt(lastNum[0]);
    lastNum         += 1;
    $('#last-tr-id').val(lastNum);
    $.ajax({
        url:app.host+"/sales/add_table_row/",
        type:"POST",
        data:{newRowID:lastNum},
        success:function (data) {
            $('#added-items-list tbody:last').append(data);
            initTouchSpin();
        }
    });
}

$(document).on('change','#warehouse',function () {
    $.ajax({
       url:app.host+"/sales/add_first_row",
        type:"POST",
        data:"add-first-row",
        success:function (data) {
            $('#added-items-list tbody').html(data);
            initTouchSpin();
        }
    });

});