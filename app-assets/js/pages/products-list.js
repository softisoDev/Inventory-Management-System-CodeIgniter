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
            "targets":[0,20,18,16,17],
            visible: false
        },
        {
            "targets":[0],
            orderable: false,
            "className": "text-center"
        },
        {
            "targets":[0,7,8,9,10,13,16,17,18,19,20,21,22],
            searchable:false
        },
        {
            "targets":[19],
            "className": "text-center",
            "width":"10px",
            "data": function ( row, type, val, meta ) {
                if(type==='display'){
                    var val = row[19]==1 ? "checked" : "unchecked";
                }
                let dataID = row[0];
                let columnData = '<input type="checkbox" data-url="products/isActiveSetter/'+dataID+'" class="js-switch" '+val+' data-size="xs"/><label for="changeDataStatus" class="font-medium-2 text-bold-600 ml-1"></label>';
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
        $('.js-switch').each(function () {
            new Switchery($(this)[0], { size: 'xsmall',className:"switchery switchery-xsmall" });
        });
    },
    "lengthMenu":[[10, 15, 25, 50, 100, -1],[10, 15, 25, 50,100, "Hamısı"]],
    "scrollY": "100vh",
    "scrollX": true,
    "pageLength": 25,
    "processing": true,
    "serverSide": true,
    "ajax": {
        url: app.host+"products/getDataTable",
        type:"POST"
    },
    dom: "<'row'<'col-md-6'l><'#createProduct.col-md-6 text-right'>>" +
        "<'row'<'#toolbar_buttons.col-md-8'B><'col-md-4'f>>"+
        "rtip",
    initComplete:function(){
        $('#createProduct').html('<a href="'+app.host+'products/create-product" target="_blank" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Məhsul Yarat</a>');
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
                    className:".dt-more-about-item",
                    action: function ( e, dt, node, config ) {
                        let get_row = drawTable.rows({ selected: true }).nodes();
                        let dataID = $(get_row[0]).data('id');
                        $.ajax({
                           url:app.host+"products/see-more",
                           type:"POST",
                           data:"productID="+dataID,
                           success:function (data) {
                               alert(data);
                           }
                        });
                    }
                },
                {
                    text:'<i class="la la-pencil"></i> Redaktə Et',
                    className:".dt-edit-item",
                    action: function ( e, dt, node, config ) {
                        let get_row = drawTable.rows({ selected: true }).nodes();
                        let dataID = $(get_row[0]).data('id');
                        window.location.href=app.host+"/products/update-product/"+dataID;
                    }
                },
                {
                    text:'<i class="la la-trash"></i> Sil',
                    className:".dt-delete-item",
                    action: function ( e, dt, node, config ) {
                        let get_row = drawTable.rows({ selected: true }).nodes();
                        let dataID = $(get_row[0]).data('id');
                        removeData("products/delete/",dataID);
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