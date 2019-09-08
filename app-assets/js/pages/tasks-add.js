$(document).ready(function () {
    initDates();
    $('#saveButton').hide();
});

function initDates(){
    let today = new Date();
    let tomorrow = new Date();
    tomorrow.setDate(today.getDate()+1);

    $("#startDate").pickadate({
        selectMonths: true,
        selectYears: true,
        min:today,
        formatSubmit: 'yyyy/mm/dd',
        format:'yyyy-m-d'
    });

    $('#endDate').pickadate({
        selectMonths: true,
        selectYears: true,
        min:tomorrow,
        formatSubmit: 'yyyy/mm/dd',
        format:'yyyy-m-d'
    });
}

function calculateTask(){
    /*let autoCode   = $('#auto-code').val();
    let taskName   = $("#task-name").val();
    let startDate  = $('#startDate').val();
    let endDate    = $('#endDate').val();*/

    let formData = $('#task-form')[0];
    $.ajax({
        url:app.host+"tasks/checkPlanAvaliablity/",
        type:"POST",
        data: new FormData(formData),
        dataType:"JSON",
        beforeSend:function(){$.blockUI({message:'<h1>Zəhmət olmasa gözləyin...</h1>'});},
        contentType:false,
        cache:false,
        processData:false,
        success:function (data) {
            if(data.error==0){
                document.getElementById('resultMessages').innerHTML = data.data.title;
                $('#resultMessages').append(data.data.messages);
                if(data.data.errorCount==0){
                    $('#saveButton').show();
                }
                else{
                    $('#saveButton').hide();
                }
                window.scrollTo(0,0);
                $.unblockUI();
            }
            else {
                $.unblockUI();
                runSweetAlert("Xəta!","Doldurulmayan sahələr var!","warning");
            }
        },
        error:function () {
            sweet_error();
        }
    })
}

$('#machine').on('change',function () {
    $.ajax({
        url:app.host+'machines/getMachine/',
        type:"POST",
        data:"machine="+$(this).val(),
        dataType:"JSON",
        success:function (data) {
            if(data.error==0){
                $('#machine-mc').val(data.data.avgMC);
                $('#cigaretteType').val(data.data.cigTypeID);
                let expTobac    = $('#cigaretteType').children("option:selected").attr('data-exp-tobacco');
                let tobacUnitID = $('#cigaretteType').children("option:selected").attr('data-unit-id');
                $('#expTobac').val(expTobac);
                $('#tobacUnitID').val(tobacUnitID);

            }
            else {
                sweet_error();
            }
        },
        error:function () {

            sweet_error();
        }

    })
    //$('#machine-mc').val();
});