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

function convertToKg(unitID, weight){
    switch (unitID) {
        case 5:
            return weight/1000000;
        case 7:
            return weight/1000;
        default:
            return weight;
    }
}

function fetchNotifications(){
    $.ajax({
       url:app.host+"notifications/makeTopNotification",
        type:"POST",
        data:"notification",
        success:function (data) {
            $('#notificationContent').html(data);
        }
    });
}
fetchNotifications();
setInterval(fetchNotifications, 300000);



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

    let findInput = $(this).prev('input[type=checkbox]');
    let data_url  = findInput.data('url');
    let isChecked = findInput.prop('checked');

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

function checkMaxQuantity(e) {
    let maxQuantity = $(e).nextAll('input').first().val();
    maxQuantity     = parseFloat(maxQuantity);
    let quantity    = parseFloat($(e).val());
    if(quantity>maxQuantity){
        runSweetAlert("Diqqət!","Daxil edilən miqdar stok miqdarından böyük ola bilməz!","warning");
        quantity = maxQuantity.toFixed(2);
        $(e).val(quantity);
    }
}

function setUnitID2Input(el){
    let data = $(el).find(':selected').attr('data-id');
    $(el).next('input').val(data);
}

function setAllUnitID2Input(){
    $('#added-items-list select').each(function () {
        let data = $(this).find(':selected').attr('data-id');
        $(this).next('input').val(data);
    })
}
