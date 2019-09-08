$(document).ready(function () {
    initTouchSpin();
    $(".switchBootstrap").bootstrapSwitch();
});

$('#itemType').on('switchChange.bootstrapSwitch',function (e,data) {
    if($('#itemType').is(':checked')){
    //    When user choose products
        $('#warehouse').prop('disabled',false);
    }
    else{
    //    When user choose premix
        $('#warehouse').prop('disabled',true);
    }
});

function addProduct(e) {
    var focusedTrID = $(e).closest('tr').attr('id');
    focusedTrID     = focusedTrID.match(/\d+$/);
    focusedTrID     = parseInt(focusedTrID[0]);
    $('#focused-tr-id').val(focusedTrID);

    /*reInitProductsTable();*/
    let warehouseID = $('#warehouse').val();

    if(warehouseID ==="" && $('#itemType').is(':checked')){
        runSweetAlert("Anbar Seçilməyib!","Zəhmət olmasa məhsulu əlavə edəcəyiniz anbarı seçin","warning");
    }
    else if (!$('#itemType').is(':checked')){
        destroyPremixesTable();
        initPremixesModal();
        $('#premixesModal').modal('show');
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
        url:app.host+"/recipes/add_table_row/",
        type:"POST",
        data:{newRowID:lastNum},
        success:function (data) {
            $('#added-items-list tbody:last').append(data);
            initTouchSpin();
        }
    });
}

function initTouchSpin(){

    $(".general-touchspin").each(function () {
        $(this).TouchSpin({
            min: 0,
            step: 0.00001,
            decimals: 5,
            boostat: 5,
            maxboostedstep: 10
        });
    });


    $(".vat").each(function () {
        $(this).TouchSpin({
            min: 0,
            max: 100,
            step: 0.5,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
    });
}

function removeRow(e) {
    var belongedTrID = $(e).data('belong-row-id');
    if(belongedTrID!==1){
        $('#items-table-row-'+belongedTrID).remove();
    }
}