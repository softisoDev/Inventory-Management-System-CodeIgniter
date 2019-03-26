function changeCurrentCurrencyValue() {
    var currentCurrency = $('#currency').val();
    $('.currency-indicator').each(function () {
        $(this).html(currentCurrency);
    });

}

$(document).on('change','#currency',function () {
    changeCurrentCurrencyValue();
});

$(document).ready(function () {
    $(".select2").each(function () {
        $(this).select2({
            language:{
                noResults:function(){return "Nəticə yoxdur"}
            }
        });
    });


    $('#date').pickadate({
        selectMonths: true,
        selectYears: true,
        formatSubmit: 'yyyy/mm/dd'
    });

    initTouchSpin();

    changeCurrentCurrencyValue();

    initProductsModal();

    $("#search-requisition").autocomplete({
        source: function (request, response) {
            $.ajax({
                type: "POST",
                url:  app.host+"/requisition/searchDataJSON/",
                data: {request:request.term},
                dataType: 'JSON',
                success: function (data) {
                    if(!data.length){
                        var result = [
                            {
                                label:'Nəticə Tapılmadı',
                                value: ""
                            }
                        ];
                        response(result);
                    }
                    else {
                        response(data);
                    }
                }
            });
        },
        minLength: 2,
        select:function (event,ui) {
            $('#requisition').val(ui.item.id);
        }
    });

    $(document).on('change','#search-requisition',function () {
       if($(this).val()==""){
           $('#requisition').val("");
       }
    });

});

function initTouchSpin(){

    $(".general-touchspin").each(function () {
        $(this).TouchSpin({
            min: 0,
            step: 0.01,
            decimals: 2,
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
        calculateGrandTotal();
        calculateTotalProductDiscount();
        calculateTotalDiscount();
    }
}

function calculateGrassTotal(e) {
    var inputName      = $(e).attr('name');
    var quantity       = 0.00;
    var price          = 0.00;
    var grassTotal     = 0.00;
    var checkSaleClass = $(e).hasClass('sale-bill');

    switch (inputName) {
        case "product-price[]":
            quantity  = $(e).closest('td').prev().find('input.product-quantity').val();
            price     = $(e).val();
            if(price==""){price = 0.00;}
            if(quantity==""){quantity = 0.00;}
            quantity        = parseFloat(quantity).toFixed(2);
            price           = parseFloat(price).toFixed(2);
            grassTotal      = (quantity*price).toFixed(2);
            $(e).closest('td').next().next().find('input.product-grassTotal').val(grassTotal);
            calculateTotalDiscount();
            calculateGrandTotal();
            break;
        case "product-quantity[]":
            price    = $(e).closest('td').next().find('input.product-price').val();
            quantity = $(e).val();
            if(checkSaleClass){
                var maxQuantity = $(e).nextAll('input').first().val();
                maxQuantity     = parseFloat(maxQuantity);
                quantity        = parseFloat(quantity);
                if(quantity>maxQuantity){
                    runSweetAlert("Diqqət!","Daxil edilən miqdar stok miqdarından böyük ola bilməz!","warning");
                    quantity = maxQuantity.toFixed(2)
                    $(e).val(quantity);
                }
            }
            if(price == ""){ price =0.00;}
            if(quantity==""){quantity = 0.00;}
            quantity        = parseFloat(quantity).toFixed(2);
            price           = parseFloat(price).toFixed(2);
            grassTotal      = (quantity*price).toFixed(2);
            $(e).closest('td').next().next().next().find('input.product-grassTotal').val(grassTotal);

            break;
    }
}

function applyDiscount(e) {
    calculateTotalProductDiscount();
    var discountValue = $(e).val();
    var grassTotal    = 0.00;
    var discount      = 0.00;
    var quantity      = $(e).closest('td').prev().prev().find('input.product-quantity').val();
    var price         = $(e).closest('td').prev().find('input.product-price').val();

    discountValue = parseFloat(discountValue).toFixed(2);
    quantity      = parseFloat(quantity).toFixed(2);
    price         = parseFloat(price).toFixed(2);
    grassTotal    = (quantity*price).toFixed(2);

    if(isNaN(discountValue)){
        $(e).closest('td').next().find('input.product-grassTotal').val(grassTotal);
        calculateTotalDiscount();
        calculateGrandTotal();
    }
    else{
        discount      = ((quantity*price)-discountValue).toFixed(2);
        $(e).closest('td').next().find('input.product-grassTotal').val(discount);
        calculateTotalDiscount();
        calculateGrandTotal();
    }

}

function calculateTotalProductDiscount() {
    var totalProductDiscount = 0;
    var discount = 0;
    $('#added-items-list tbody tr').each(function () {
        discount  = $(this).find(':nth-child(6)').find('input.product-discount').val();
        discount  = parseFloat(discount);
        if(isNaN(discount)){
            discount = 0;
        }
        totalProductDiscount +=discount;
    });

    totalProductDiscount = totalProductDiscount.toFixed(2);
    $('#totalProductDiscount').html(totalProductDiscount);
    $('#totalProductDiscount-input').val(totalProductDiscount);
    return totalProductDiscount;
}

function calculateTotalDiscount() {
    var generalDiscountValue   = $('#generalDiscountValue').val();
    var totalProductDiscount   = calculateTotalProductDiscount();
    if(isNaN(parseFloat(generalDiscountValue))){
        generalDiscountValue   = 0;
    }
    var totalDiscount = (parseFloat(totalProductDiscount)+parseFloat(generalDiscountValue)).toFixed(2);

    $('#totalDiscount').html(totalDiscount);
    $('#totalDiscount-input').val(totalDiscount);
    calculateGrandTotal();

}

function calculateGrandTotal() {
    var grandTotal = 0;
    var grassTotal = 0;
    var generalDiscountValue = $('#generalDiscountValue').val();
    generalDiscountValue     = parseFloat(generalDiscountValue).toFixed(2);
    $('#added-items-list tbody tr').each(function () {
        grassTotal  = $(this).find(':nth-child(7)').find('input.product-grassTotal').val();
        grassTotal  = parseFloat(grassTotal);
        if(isNaN(grassTotal)){
            grassTotal = 0;
        }
        grandTotal +=grassTotal;
    });
    grandTotal = parseFloat(grandTotal).toFixed(2);
    if(!isNaN(generalDiscountValue)){
        grandTotal = (parseFloat(grandTotal)-parseFloat(generalDiscountValue)).toFixed(2);
    }

    $('#grandTotal').html(grandTotal);
    $('#grandTotal-input').val(grandTotal);
}

function calculateVAT(e) {
    calculateGrandTotal();
    var grandTotal = $('#grandTotal-input').val();
    var vatValue   = $(e).val();
    if(vatValue == ""){vatValue=0.00}
    var totalVAT   = 0.00;

    grandTotal     = parseFloat(grandTotal).toFixed(2);
    vatValue       = parseFloat(vatValue).toFixed(2);

    totalVAT       = (vatValue*grandTotal)/100;
    totalVAT       = parseFloat(totalVAT).toFixed(2);

    $('#totalVAT').val(totalVAT);
}