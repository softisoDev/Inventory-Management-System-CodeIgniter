function runToastr(title,text,type,position="toast-top-center") {

    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": position,
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "3600",
        "hideDuration": "300",
        "timeOut": "3000", //Istifadeci toxunmadigi muddetce nece saniye gosterileceyi
        "extendedTimeOut": "3000", //Istifadeci hover etdikden sonra nece saniye gosterileceyi
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",//fadeIn
        "hideMethod": "slideUp",//slideUp
        "closeMethod":"slideUp",//fadeOut
        "tapToDismiss": true,
        "closeOnHover":true
    }

    switch (type) {
        case "error":
            toastr.error(text,title);
            break;

        case "success":
            toastr.success(text,title);
            break;

        case "info":
            toastr.info(text,title);
            break;

        case "warning":
            toastr.warning(text,title);
            break;
    }

}