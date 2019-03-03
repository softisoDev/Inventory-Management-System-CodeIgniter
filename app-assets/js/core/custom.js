function runSweetAlert(title,text,type,buttonClass="btn-"+type,buttonText="Oldu",closeClickOnConfirm=true){
    swal({
        title: title,
        text: text,
        type: type,
        showCancelButton: false,
        confirmButtonClass: buttonClass,
        confirmButtonText: buttonText,
        closeOnConfirm: true,
    });
}

function sweet_error(){
    swal({
        title: "Üzr istəyirik bilinməyən xəta baş verdi!",
        text: "Zəhmət olmasa birazdan bir daha cəhd edin",
        type: "error",
        showCancelButton: false,
        confirmButtonClass: "btn-error",
        confirmButtonText: "Oldu",
        closeOnConfirm: true,
    });
}

function removeData(url,id) {
    swal({
            title: "Silmək istədiyinizdən əminmisiniz?",
            text: "Nəzərinizə çatdırırıq ki, bu əməliyyat GERİ QAYTARILA BİLMƏZ!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Sil!",
            cancelButtonText: "Ləğv Et",
            closeOnConfirm: false,
            closeOnCancel: true
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href = app.host+url+id;
            }
        }
    );
}

$('table').on('click','.switchery',function () {

    var findInput = $(this).prev('input[type=checkbox]');
    var data_url  = findInput.data('url');
    var isChecked = findInput.prop('checked');

    if(typeof data_url != "undefined" && typeof isChecked != "undefined"){
        $.ajax({
            url:app.host+data_url,
            type: "POST",
            data:"isChecked="+isChecked,
            success:function (data) {
                runSweetAlert("Əməliyyat uğurla yerinə yetirlidi","","success");
            },
            error:function () {
                sweet_error();
            }
        })
    }

});

