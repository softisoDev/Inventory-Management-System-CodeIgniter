var drawTable = $('#productsTable').DataTable( {
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
            "targets":[0,20,18,17],
            visible: false
        },
        {
            "targets":[0],
            orderable: false,
            "className": "text-center all"
        },
        {
            "targets":[0,7,8,9,10,13,16,17,18,19,20,21,22],
            searchable:false
        }
    ],
    "lengthMenu":[10, 15, 25, 50,100, "Hamısı"],
    "scrollY": "50vh",
    "scrollX": true,
    "pageLength": 10,
    "processing": true,
    "serverSide": true,
    "ajax": {
        url: app.host+"products/getProductsTable",
        type:"POST"
    },
    //dom: 'Bfrtip',
    dom: "<'row'<'col-md-6'l><'#createProduct.col-md-6 text-right'>>" +
        "<'row'<'#toolbar_buttons.col-md-8'B><'col-md-4'f>>"+
        "rtip",
    initComplete:function(){
        $('#createProduct').html('<button type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Məhsul Yarat</button>');
        drawTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
            var singleRow = this.node();
            dataID = drawTable.row(singleRow).data()[0];
            $(singleRow).attr('data-product-id', dataID);
        });
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
                    text:'<i class="la la-eye"></i> Daha Ətraflı',
                },
                {
                    text:'<i class="la la-pencil"></i> Redaktə Et'
                },
                {
                    text:'<i class="la la-trash"></i> Sil'
                }
            ],
        },
    ],

    select: true
});


drawTable.on( 'select', function ( e, dt, type, indexes ) {
    var get_row = drawTable.rows({ selected: true }).nodes();
    var productID = $(get_row[0]).data('product-id');
    var length = drawTable.rows('.selected').data().length;
    if(length==1){
        drawTable.buttons(['.actions']).enable();
    }
    else {
        drawTable.buttons(['.actions']).disable();
    }
});

drawTable.on( 'deselect', function ( e, dt, type, indexes ) {
    drawTable.buttons(['.actions']).disable();

});


$(document).ready(function () {

});