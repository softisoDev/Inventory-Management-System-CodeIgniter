$(document).ready(function () {
    initTouchSpin();
    $(".switchBootstrap").bootstrapSwitch();
});

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
        url:app.host+"/premixes/add_table_row/",
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
    if(belongedTrID!=1){
        $('#items-table-row-'+belongedTrID).remove();
    }
    calcTotalAmount();
    calcRatio();
}

function gcd(a, b){

    if(a<b){
        return gcd(b,a);
    }
    if(Math.abs(b)<0.00001){
        return a;
    }
    else {
        return (gcd(b, a-Math.floor(a/b)*b));
    }
}

function findMultipleGCD(numsArr) {
    return numsArr.reduce(gcd);
}

function getAllRatio(){
    let ratioArr = [];
    let ratio = 0;
    $('input[name="product-quantity[]"]').each(function () {
        if($(this).val() !== ""){
            //ratio = Math.round(parseFloat(totalAmount)/parseFloat($(this).val()));
            ratio = parseInt($(this).val());
            ratioArr.push($(this).val());
        }
        else {
            ratioArr.push(0);
        }
    });
    return ratioArr;
}

function calcRatio(el){
    checkMaxQuantity(el);
    let ratio = 0;
    let ratioArr = getAllRatio();
    let arrGCD   = findMultipleGCD(ratioArr);
    $('input[name="product-quantity[]"]').each(function () {
        if($(this).val() !== ""){
            ratio = (parseFloat($(this).val())/arrGCD).toFixed(0);

            $(this).closest('td').next().find('input.product-ratio').val(ratio);
        }
        else {
            $(this).closest('td').next().find('input.product-ratio').val(0);
        }
    });
    calcTotalAmount();
}



function calcTotalAmount(){
    let netAmount = 0;
    let unitID = 4;
    $('input[name="product-quantity[]"]').each(function () {
        unitID = $(this).closest('td').prev('td').find('input.product-unit-db').val();
        unitID = parseInt(unitID);
        if($(this).val() !== ""){
            if(unitID == 4){
                netAmount += parseFloat($(this).val());
            }
            else{
                netAmount += parseFloat(convertToKg(unitID,parseFloat($(this).val())));
            }
        }
        else {
            netAmount += 0;
        }
    });
    $("#premix-total-amount").html(parseFloat(netAmount).toFixed(6));
    $('input[name="premix-total-amount"]').val(parseFloat(netAmount).toFixed(6));
    return netAmount;
}


/*
$('select.product-unit').on('change','.product-unit',function () {

});*/
