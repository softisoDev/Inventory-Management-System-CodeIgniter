<style>
    #premixesTable_processing.card{
        min-width: 0 !important;
        z-index: 99999;
        font-weight: bolder;
    }
</style>
<!-- Premixes Modal -->
<div class="modal" id="premixesModal" data-backdrop="static">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Premixes</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="card-body card-dashboard">
                    <table id="premixesTable" class="table full-width display nowrap table-striped table-bordered scroll-horizontal-vertical base-style dtTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Avto Kod</th>
                            <th>Kodu</th>
                            <th>Adı</th>
                            <th>Miqdarı</th>
                            <th>Ölçü Vahidi</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Avto Kod</th>
                            <th>Kodu</th>
                            <th>Adı</th>
                            <th>Miqdarı</th>
                            <th>Ölçü Vahidi</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function initPremixesModal() {
        let url = app.host+"premixes/getDataTable";

        let drawTable = $('#premixesTable').DataTable( {
            "language": {
                "url": app.host+"app-assets/vendors/js/tables/datatable/locale/Azerbaijan.json"
            },
            "order": [[ 0, "desc" ]],
            columnDefs:[
                {
                    "targets":[0],
                    visible: false
                },
                {
                    "targets":[0],
                    orderable: false,
                    "className": "text-center"
                },
                {
                    "targets":[0],
                    searchable:false
                },

            ],
            "fnDrawCallback": function() {
                drawTable.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                    var singleRow = this.node();
                    dataID = drawTable.row(singleRow).data()[0];
                    $(singleRow).attr('data-id', dataID);
                });
            },
            "lengthMenu":[[10, 15, 25, 50,100, -1], [10, 15, 25, 50,100, "Hamısı"]],
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
                $('#createProduct').html('<a href="'+app.host+'premixes/add-premix" target="_blank" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Premix əlavə et</a>');
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

                        let premixID   =  drawTable.row(get_row).data()[0];
                        let premixCode = drawTable.row(get_row).data()[2];
                        let premixName = drawTable.row(get_row).data()[3];
                        let premixUnit = drawTable.row(get_row).data()[5];
                        let focusedTrID = $('#focused-tr-id').val();
                        let row = $('#items-table-row-'+focusedTrID);
                        let maxQuantity = drawTable.row(get_row).data()[4];

                        row.find('td:nth-child(1) input.product-code').val(premixCode);
                        row.find('td:nth-child(1) input.premixID').val(premixID);
                        row.find('td:nth-child(2) input').val(premixName);
                        row.find('td:nth-child(3) select').val(premixUnit);
                        row.find('td:nth-child(4) input.max-quantity').val(maxQuantity);

                        if(typeof setAllUnitID2Input === 'function'){
                            setAllUnitID2Input();
                        }

                        $('#premixesModal').modal('hide');
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
    function reInitPremixesTable() {
        $('#premixesTable').DataTable().ajax.reload();
    }
    function destroyPremixesTable() {
        $('#premixesTable').DataTable().destroy();
    }
</script>