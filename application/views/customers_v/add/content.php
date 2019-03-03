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
                        <form class="form" method="post" action="<?php echo base_url('customers/save'); ?>">
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="auto-code">Avtomatik Kod</label>
                                            <input type="text" readonly value="<?php echo $newCode; ?>" id="auto-code"
                                                   class="form-control border-primary" placeholder="Avtomatik Kod" name="auto-code">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('auto-code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="code">Kodu</label>
                                            <input type="text" id="code" class="form-control border-primary" placeholder="Kodu" name="code">
                                            <?php if(isset($form_error)): ?>
                                            <span class="font-italic red font-weight-bold"><?php echo form_error('code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer-name">Adı</label>
                                            <input type="text" id="customer-name" class="form-control border-primary" placeholder="Müştəri/Cari Adı" name="customer-name">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('customer-name'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="company">Şirkət Adı</label>
                                            <input type="text" id="company" class="form-control border-primary" placeholder="Şirkət Adı" name="company">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" class="form-control border-primary" placeholder="Email" name="email">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="telephone">Telefon</label>
                                            <input type="text" id="telephone" class="form-control border-primary" placeholder="Telefon" name="telephone">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="country">Ölkə</label>
                                            <input type="text" id="country" class="form-control border-primary" placeholder="Ölkə" name="country">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="city">Şəhər</label>
                                            <input type="text" id="city" class="form-control border-primary" placeholder="Şəhər" name="city">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="address">Ünvan</label>
                                            <input type="text" id="address" class="form-control border-primary" placeholder="Ünvan" name="address">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="zipcode">Poçt Kodu</label>
                                            <input type="text" id="zipcode" class="form-control border-primary" placeholder="Poçt Kodu" name="zipcode">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="special1">Xüsusi Sahə 1</label>
                                            <input type="text" id="special1" class="form-control border-primary" placeholder="Xüsusi Sahə 1" name="special1">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="special2">Xüsusi Sahə 1</label>
                                            <input type="text" id="special2" class="form-control border-primary" placeholder="Xüsusi Sahə 2" name="special2">
                                        </div>
                                    </div>


                                </div>

                                </div>

                            </div>
                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('customers'); ?>" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Ləğv Et
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> Saxla
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
