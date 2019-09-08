$(document).ready(function () {

    $('.date-input').pickadate({
        selectMonths: true,
        selectYears: true,
        formatSubmit: 'yyyy-mm-dd',
        format: 'yyyy-mm-dd',
    });
});

$("#search-product").autocomplete({
    source: function (request, response) {
        $.ajax({
            type: "POST",
            url:  app.host+"/products/searchDataJSON/",
            data: {productCode:request.term},
            dataType: 'JSON',
            success: function (data) {
                if(!data.length){
                    let result = [
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
        $('#product-code').val(ui.item.id);
    }
});

function checkValue(el) {
    if($(el).val() ==""){
        $('#product-code').val("");
    }
}

function applyFilter() {
    destroyDataTable();
    let productCode = $('#product-code').val();
    let startDate   = $('#startDate').val();
    let endDate     = $('#endDate').val();

    if(productCode == ""){
        runSweetAlert("Məhsul kodu boş buraxılaq bilməz!","","warning");
        return false;
    }
    if(startDate == ""){
        runSweetAlert("Başlanğıc tarix boş buraxılaq bilməz!","","warning");
        return false;
    }
    if(endDate == ""){
        runSweetAlert("Son tarix boş buraxılaq bilməz!","","warning");
        return false;
    }
    initDataTable(startDate, endDate, productCode);
}

function initDataTable(startDate, endDate, productCode){
    let drawTable = $('#itemHandlingsTable').DataTable( {
        "language": {
            "url": app.host+"app-assets/vendors/js/tables/datatable/locale/Azerbaijan.json",
            buttons: {
                copyTitle: 'Kopyalandı',
                copySuccess: {
                    _: '%d Sətir Kopyalandı',
                    1: '1 Sətir Kopyalandı'
                }
            }
        },
        "order": [[ 0, "desc" ]],
        columnDefs:[
            {
                "targets":[0],
                orderable: false,
                visible: false
            },
            {
                "targets":[1],
                "className": "text-center",
                "data": function ( row, type, val, meta ) {
                    let columnData = "";
                    if(type==='display'){
                        let findIconType = row[1].search('plus');
                        if(findIconType>0){
                            columnData = '<i class="green '+row[1]+'"></i>';
                        }
                        findIconType = row[1].search('minus');
                        if(findIconType>0){
                            columnData = '<i class="red '+row[1]+'"></i>';
                        }
                        findIconType = row[1].search('sync');
                        if(findIconType>0){
                            columnData = '<i class="blue '+row[1]+'"></i>';
                        }
                    }
                    return columnData;
                }
            }
        ],
        "fnDrawCallback": function() {
            drawTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                var singleRow = this.node();
                dataID = drawTable.row(singleRow).data()[0];
                $(singleRow).attr('data-id', dataID);
            });
        },
        "lengthMenu":[[10, 15, 25, 50, 100, -1],[10, 15, 25, 50, 100, "Hamısı"]],
        "scrollY": "100vh",
        "scrollX": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: app.host+"item_handlings/getDataTable",
            type:"POST",
            "data" : {
                "startDate"   : startDate,
                "endDate"     : endDate,
                "productCode" : productCode
            }
        },
        dom: "<'row'<'col-md-6'l><'#createNew.col-md-6 text-right'>>" +
            "<'row'<'#toolbar_buttons.col-md-8'B><'col-md-4'f>>"+
            "rtip",
        initComplete:function(){
        },
        buttons: [
            {
                extend:'collection',
                text:'<i class="la la-copy"></i>Kopyala',
                buttons:[
                    {
                        extend:'copyHtml5',
                        text:'Hamısını',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend:'copyHtml5',
                        text:'Seçilənləri',
                        exportOptions:{
                            columns: ':visible',
                            modifier:{
                                selected:true
                            }
                        }
                    }
                ],
            },
            {
                extend:'collection',
                text:'<i class="la la-print"></i>Çap Et',
                buttons:[
                    {
                        extend:'print',
                        text:'Hamısını',
                        autoPrint: false,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend:'print',
                        text:'Seçilənləri',
                        autoPrint: false,
                        exportOptions:{
                            columns: ':visible',
                            modifier:{
                                selected:true
                            }
                        }
                    }
                ],
            },
            {
                extend:"excelHtml5",
                text:"<i class='la la-file-excel-o'></i> Excel",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend:"pdfHtml5",
                text:"<i class='la la-file-pdf-o'></i> PDF",
                pageSize: 'A4',
                orientation: 'portrait',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text:   "Sütunlar",
            },
            {
                text:'<i class="fa fa-retweet"></i> Yenilə',
                action:function (e, dt, node, config) {
                    drawTable.ajax.reload();

                }
            },
            {
                extend:"collection",
                text:  '<i class="la la-cog"></i> Əməliyyatlar',
                className:"actions",
                enabled: false,
                buttons:[
                    {
                        text:'<i class="la la-pencil"></i> Redaktə Et',
                        className:".dt-edit-item",
                        action: function ( e, dt, node, config ) {
                            var get_row = drawTable.rows({ selected: true }).nodes();
                            var dataID = $(get_row[0]).data('id');
                            window.location.href=app.host+"item_handlings/update-branch/"+dataID;
                        }
                    },
                    {
                        text:'<i class="la la-trash"></i> Sil',
                        className:".dt-delete-item",
                        action: function ( e, dt, node, config ) {
                            var get_row = drawTable.rows({ selected: true }).nodes();
                            var dataID = $(get_row[0]).data('id');
                            removeData("item_handlings/delete/",dataID);
                        }
                    }
                ],
            },
        ],
        select: true
    });
}

function reInitDataTable() {
    $('#itemHandlingsTable').DataTable().ajax.reload();
}
function destroyDataTable() {
    $('#itemHandlingsTable').DataTable().destroy();
}
