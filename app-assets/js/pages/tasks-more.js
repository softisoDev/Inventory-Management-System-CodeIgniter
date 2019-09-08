$(document).ready(function () {
    initDates();
});

function initDates(){

    $("#today").pickadate({
        selectMonths: true,
        selectYears: true,
        formatSubmit: 'yyyy/mm/dd',
        format:'yyyy-m-d'
    });
}