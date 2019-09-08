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

                        <table id="tasksTable" class="table full-width display nowrap table-striped table-bordered scroll-horizontal-vertical base-style dtTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Task kodu</th>
                                <th>Task adı</th>
                                <th>Başlanğıc tarixi</th>
                                <th>Bitiş tarixi</th>
                                <th>Reçete</th>
                                <th>Makina</th>
                                <th>Sigara tipi</th>
                                <th>Task haqqında</th>
                                <th>İlerleme statusu</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Task kodu</th>
                                <th>Task adı</th>
                                <th>Başlanğıc tarixi</th>
                                <th>Bitiş tarixi</th>
                                <th>Reçete</th>
                                <th>Makina</th>
                                <th>Sigara tipi</th>
                                <th>Task haqqında</th>
                                <th>İlerleme statusu</th>
                                <th>Status</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
