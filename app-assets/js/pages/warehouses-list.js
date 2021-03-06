var drawTable = $('#warehousesTable').DataTable( {
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
        url: app.host+"warehouses/getDataTable",
        type:"POST"
    },
    dom: "<'row'<'col-md-6'l><'#createNew.col-md-6 text-right'>>" +
        "<'row'<'#toolbar_buttons.col-md-8'B><'col-md-4'f>>"+
        "rtip",
    initComplete:function(){
        $('#createNew').html('<a href="'+app.host+'warehouses/add-warehouse" target="_blank" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Anbar Əlavə Et</a>');
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
                        window.location.href=app.host+"warehouses/update-warehouse/"+dataID;
                    }
                },
                {
                    text:'<i class="la la-trash"></i> Sil',
                    className:".dt-delete-item",
                    action: function ( e, dt, node, config ) {
                        var get_row = drawTable.rows({ selected: true }).nodes();
                        var dataID = $(get_row[0]).data('id');
                        removeData("warehouses/delete/",dataID);
                    }
                }
            ],
        },
    ],
    select: true
});
drawTable.on( 'select', function ( e, dt, type, indexes ) {
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
