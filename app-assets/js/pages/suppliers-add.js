$(document).ready(function () {

    $(".select2").each(function () {
        $(this).select2({
            language:{
                noResults:function(){return "Nəticə yoxdur"}
            }
        });
    });

});