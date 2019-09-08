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
                        <form class="form" method="post" action="<?php echo base_url('cigarette_types/save'); ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">

                                        <div class="form-group">
                                            <label for="cigarette-name" class="pull-left"><strong>Adı:</strong></label>
                                            <input type="text" id="cigarette-name" name="cigarette-name" class="form-control" required placeholder="Adı">
                                            <div>
                                                <?php if(isset($form_error)): ?>
                                                    <span class="pull-left font-italic red font-weight-bold"><?php echo form_error('cigarette-name'); ?></span>
                                                <?php endif; ?>
                                            </div><?php if (isset($form_error)){echo "<br/>";} ?>
                                        </div>


                                        <div class="form-group">
                                            <label for="expTobac" class="pull-left"><strong>Tütün Miqdarı:</strong></label>
                                            <input type="number" min="1" step="1" id="expTobac" name="expTobac" class="form-control" required placeholder="Tütün Miqdarı">
                                            <div>
                                                <?php if(isset($form_error)): ?>
                                                    <span class="pull-left font-italic red font-weight-bold"><?php echo form_error('expTobac'); ?></span>
                                                <?php endif; ?>
                                            </div><?php if (isset($form_error)){echo "<br/>";} ?>
                                        </div>



                                        <div class="form-group">
                                            <label class="pull-left"><strong>Ölçü vahidi:</strong></label>
                                            <select required class="form-control" name="unit-name" id="unit-name">
                                                <option value="">Ölçü vahidi seçin</option>
                                                <?php
                                                    foreach ($units as $unit){
                                                        echo '<option value="'.$unit->ID.'">'.$unit->name.'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <div>
                                                <?php if(isset($form_error)): ?>
                                                    <span class="pull-left font-italic red font-weight-bold"><?php echo form_error('unit-name'); ?></span>
                                                <?php endif; ?>
                                            </div><?php if (isset($form_error)){echo "<br/>";} ?>
                                        </div>


                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('cigarette-types'); ?>" class="btn btn-warning mr-1">
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
