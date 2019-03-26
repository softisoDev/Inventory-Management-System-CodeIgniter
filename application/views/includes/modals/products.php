<style>
    #productsTable_processing.card{
        min-width: 0 !important;
        z-index: 99999;
        font-weight: bolder;
    }
</style>
<!-- Products Modal -->
<div class="modal" id="myModal" data-backdrop="static">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Məhsullar</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="card-body card-dashboard">
                    <table id="productsTable" class="table full-width display nowrap table-striped table-bordered scroll-horizontal-vertical base-style dtTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Avto Kod</th>
                            <th>Kodu</th>
                            <th>Adı</th>
                            <th>Marka</th>
                            <th>Kateqoriya</th>
                            <th>Ölçü Vahidi</th>
                            <th>Qiyməti</th>
                            <th>Satış Qiyməti</th>
                            <th>Satış Qiyməti-2</th>
                            <th>ƏDV</th>
                            <th>Barkod</th>
                            <th>Barkod-2</th>
                            <th>Stok Miqdarı</th>
                            <th>Kritik Stok Miqdarı</th>
                            <th>Rəf No</th>
                            <th>Yaradılma Tarixi</th>
                            <th>Xüsusi Sahə-1</th>
                            <th>Xüsusi Sahə-2</th>
                            <th>Status</th>
                            <th>Son Redaktə Olunma Tarixi</th>
                            <th>Açıqlama</th>
                            <th>Dəyişən Kodu</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Avto Kod</th>
                            <th>Kodu</th>
                            <th>Adı</th>
                            <th>Marka</th>
                            <th>Kateqoriya</th>
                            <th>Ölçü Vahidi</th>
                            <th>Qiyməti</th>
                            <th>Satış Qiyməti</th>
                            <th>Satış Qiyməti-2</th>
                            <th>ƏDV</th>
                            <th>Barkod</th>
                            <th>Barkod-2</th>
                            <th>Stok Miqdarı</th>
                            <th>Kritik Stok Miqdarı</th>
                            <th>Rəf No</th>
                            <th>Yaradılma Tarixi</th>
                            <th>Xüsusi Sahə-1</th>
                            <th>Xüsusi Sahə-2</th>
                            <th>Status</th>
                            <th>Son Redaktə Olunma Tarixi</th>
                            <th>Açıqlama</th>
                            <th>Dəyişən Kodu</th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

<script>
    function initProductsModal(warehouse="") {
    var url = app.host+"products/getDataTable";

    warehouse = parseInt(warehouse);

    if(warehouse!="" && !isNaN(warehouse)){
        url = app.host+"products/getDataTable/"+warehouse;
    }
    var drawTable = $('#productsTable').DataTable( {
        "language": {
            "url": app.host+"app-assets/vendors/js/tables/datatable/locale/Azerbaijan.json"
        },
        "order": [[ 0, "desc" ]],
        columnDefs:[
            {
                "targets":[0,20,18,15,16,17,19,20,21,22,18,12,11,9,10],
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
        "lengthMenu":[10, 15, 25, 50,100, "Hamısı"],
        "scrollY": "50vh",
        "scrollX": true,
        "pageLength": 10,
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: url,
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
                text:  '<i class="la la-plus"></i> Əlavə Et',
                className:"add-data",
                enabled: false,
                action: function ( e, dt, node, config ) {
                    var get_row = drawTable.rows({ selected: true }).nodes();

                    var productID   = drawTable.row(get_row).data()[0];
                    var productCode = drawTable.row(get_row).data()[2];
                    var productName = drawTable.row(get_row).data()[3];
                    var productUnit = drawTable.row(get_row).data()[6];
                    var focusedTrID = $('#focused-tr-id').val();
                    var row = $('#items-table-row-'+focusedTrID);
                    row.find('td:nth-child(1) input.product-code').val(productCode);
                    row.find('td:nth-child(1) input.productID').val(productID);
                    row.find('td:nth-child(2) input').val(productName);
                    row.find('td:nth-child(3) select').val(productUnit);
                    if(warehouse!="" || !isNaN(warehouse)){
                        var maxQuantity = drawTable.row(get_row).data()[13];
                        row.find('td:nth-child(4) input.max-quantity').val(maxQuantity);
                    }

                    $('#myModal').modal('hide');
                }
            }
        ],
        select: true
    });

    drawTable.on( 'select', function ( e, dt, type, indexes ) {
        var length = drawTable.rows('.selected').data().length;
        if(length==1){
            drawTable.buttons(['.add-data']).enable();
        }
        else {
            drawTable.buttons(['.add-data']).disable();
        }
    });

    drawTable.on( 'deselect', function ( e, dt, type, indexes ) {
        drawTable.buttons(['.add-data']).disable();
    });
    }
    function reInitProductsTable() {
        $('#productsTable').DataTable().ajax.reload();
    }
    function destroyProductsTable() {
        $('#productsTable').DataTable().destroy();
    }
</script>