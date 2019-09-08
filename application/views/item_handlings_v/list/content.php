<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo $header; ?></h3>
    </div>
</div>

<section id="horizontal-vertical">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">

                        <div class="row">

                            <div class="col-md-3">
                                <fieldset class="form-group">
                                    <label for="requisition">Məhsul kodu</label>
                                    <div class="input-group">
                                        <input onkeyup="checkValue(this)" type="text" class="form-control border-primary" id="search-product" name="search-product" />
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ft-search"></i></span>
                                        </div>
                                        <input type="hidden" class="form-control border-primary" value="" id="product-code" name="product-code" />
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-2">
                                <label for="startDate">Başlanğıc tarixi</label>
                                <input type="text" required id="startDate" class="form-control border-primary date-input" name="startDate" placeholder="Başlanğıc tarixi">
                            </div>

                            <div class="col-md-2">
                                <label for="endDate">Son tarix</label>
                                <input value="<?php echo date('Y-m-d'); ?>" type="text" required id="endDate" class="form-control border-primary date-input" name="endDate">
                            </div>

                            <div class="col-md-5 text-right pt-2">
                                <button onclick="applyFilter()" id="apply-filter" class="btn btn-warning" type="button">Filtr tətbiq et</button>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="itemHandlingsTable" class="table full-width display nowrap table-striped table-bordered scroll-horizontal-vertical base-style dtTable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="col-xs-1"></th>
                                        <th>Kodu</th>
                                        <th>Adı</th>
                                        <th>Fatura &#8470;</th>
                                        <th>Tarix</th>
                                        <th>Daxil olduğu anbar</th>
                                        <th>Çıxdığı anbar</th>
                                        <th>Miqdarı</th>
                                        <th>Ölçü vahidi</th>
                                        <th>Qiyməti</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th class="col-xs-1"></th>
                                        <th>Kodu</th>
                                        <th>Adı</th>
                                        <th>Fatura &#8470;</th>
                                        <th>Tarix</th>
                                        <th>Daxil olduğu anbar</th>
                                        <th>Çıxdığı anbar</th>
                                        <th>Miqdarı</th>
                                        <th>Ölçü vahidi</th>
                                        <th>Qiyməti</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
