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
                        <?php if(!$result){echo '<h1 class="red font-weight-bold">Məlumat tapılmadı!</h1>';exit();} ?>
                        <form class="form" method="post" action="<?php echo base_url('departments/update/').$department->ID; ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">

                                        <div class="form-group">
                                            <label for="code">Adı</label>
                                            <input type="text" id="department-name" class="form-control border-primary" placeholder="Adı" name="department-name" required value="<?php echo $department->name; ?>">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('department-name'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Filial</label>
                                            <select name="branch" class="form-control border-primary">
                                                <option value="">Filial seç</option>
                                                <?php foreach ($branches as $branch){ ?>
                                                    <option
                                                            <?php echo ($branch->ID==$department->branchID)?"selected":""; ?>
                                                            value="<?php echo $branch->ID; ?>">
                                                        <?php echo $branch->name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('branch'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Email</label>
                                            <input type="email" id="mail" class="form-control border-primary" placeholder="Email" name="mail" value="<?php echo $department->email; ?>">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('mail'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Telefon</label>
                                            <input type="text" id="telephone" class="form-control border-primary" placeholder="Telefon" name="telephone" value="<?php echo $department->telephone; ?>">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('telephone'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Haqqında</label>
                                            <textarea class="form-control border-primary" name="description" rows="5" placeholder="Haqqında"><?php echo $department->description; ?></textarea>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('description'); ?></span>
                                            <?php endif; ?>
                                        </div>


                                    </div>
                                    <div class="col-md-4"></div>
                                </div>

                            </div>
                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('departments'); ?>" class="btn btn-warning mr-1">
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
