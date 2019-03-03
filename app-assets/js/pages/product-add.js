$(document).ready(function () {
    $(".select2").each(function () {
        $(this).select2({
            language:{
                noResults:function(){return "Nəticə yoxdur"}
            }
        });
    });

    $("#vat").TouchSpin({
        min: 0,
        max: 100,
        step: 0.5,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });
    $(".costs").TouchSpin({
        min: 0,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        postfix: 'AZN'
    });

    $("#critic-amount").TouchSpin({
        min: 0,
        step: 1,
        boostat: 5,
        maxboostedstep: 10,
    });

});