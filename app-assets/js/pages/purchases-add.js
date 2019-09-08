function addProduct(e) {
    let focusedTrID = $(e).closest('tr').attr('id');
    focusedTrID     = focusedTrID.match(/\d+$/);
    focusedTrID     = parseInt(focusedTrID[0]);
    $('#focused-tr-id').val(focusedTrID);

    let warehouseID = $('#warehouse').val();
    if(warehouseID===""){
        runSweetAlert("Anbar Seçilməyib!","Zəhmət olmasa anbar seçin","warning");
    }
    else {
        destroyProductsTable();
        initProductsModal();
        $('#myModal').modal('show');
    }
}

function importFromCsv(el){
    let formData = new FormData();
    if($(el).prop('files').length > 0)
    {
       let file =$(el).prop('files')[0];
        formData.append("csvFile", file);
    }
    $.ajax({
        url: app.host+'purchases/importCsvFile',
        type: "POST",
        data: formData,
        dataType:"JSON",
        beforeSend:function(){$.blockUI({message:'<h1>Please wait...</h1>'});},
        processData: false,
        contentType: false,
        success: function (data) {
            /*$('#product-list-content').html(data.rowHtml);*/
            $('#messageContent').html(data.message);
            $('#messageModal').show();
            $.unblockUI();
        },
        error:function () {
            $.unblockUI();
            sweet_error();
        }
    });
}



function addNewRow() {

    let lastTrID    = $('#added-items-list tbody').find('tr:last').attr('id');
    let lastNum     = lastTrID.match(/\d+$/);
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
