$(document).ready(function () {

});

function fetchDepartment(el){
    let branchID = $(el).val();
    $.ajax({
       url:app.host+"departments/getSelectBox",
        type:"POST",
        data:"branchID="+branchID,
        success:function (data) {
            $('#department').html(data);
        },
        error:function () {
            sweet_error();
        }
    });
}