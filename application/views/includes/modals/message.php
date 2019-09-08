<!-- Message Modal -->
<div class="modal" id="messageModal" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Mesaj</h4>
                <button type="button" class="close" onclick="$('#messageModal').hide();" data-dismiss="messageModal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="card-body card-dashboard" id="messageContent">
                    <!--<h3 class="success font-weight-bold" id="header-message"></h3>
                    <p>
                        <span class="font-weight-bold">Dosyadaki toplam ürün sayısı: </span> <span id="totalItems"></span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Eklenen ürün sayısı: </span> <span id="addedItemsCount"></span>
                    </p>
                    <p>
                        <span class="font-weight-bold">Bulunmayan ürün sayısı: </span> <span id="undefinedItemsCount"></span>
                    </p>
                    <div class="collapse-icon accordion-icon-rotate">
                        <div id="headingCollapse12" class="card-header p-0">
                        <a data-toggle="collapse" href="#collapse12" aria-expanded="false" aria-controls="collapse12"
                           class="card-title lead collapsed">Bulunmayan ürünler listesi</a>
                    </div>
                        <div id="collapse12" role="tabpanel" aria-labelledby="headingCollapse12" class="collapse"
                         aria-expanded="false">
                        <div class="card-content">
                            <div class="card-body" id="undefinedItemsContent">

                            </div>
                        </div>
                    </div>
                    </div>-->
                </div>
            </div>

            <div class="modal-footer">
                <button onclick="$('#messageModal').hide();" type="button" class="btn grey btn-outline-secondary" data-dismiss="messageModal">Kapat</button>
            </div>

        </div>
    </div>
</div>