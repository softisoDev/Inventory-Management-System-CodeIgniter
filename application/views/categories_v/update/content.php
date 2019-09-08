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
                        <?php if (!$result){echo '<h1 class="red font-weight-bold">Məlumat Tapılmadı</h1>'; exit();} ?>
                        <form class="form" method="post" action="<?php echo base_url('categories/update/').$category->ID; ?>">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">

                                        <div class="form-group">
                                            <label for="code">Adı</label>
                                            <input type="text" id="category-name" class="form-control border-primary" placeholder="Adı" name="category-name" required value="<?php echo $category->name; ?>">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('category-name'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="code">Ana kateqoriya</label>
                                            <select name="parentCategory" required class="form-control border-primary">
                                                <option value="">Kateqoriya seç</option>
                                                <option value="0" <?php echo ($category->parentID==0)?"selected":"";?>>Ana kateqoriya</option>
                                                <?php foreach ($categories as $category2){ ?>
                                                    <option
                                                            <?php echo ($category->parentID==$category2->ID)?"selected":"";?>
                                                            value="<?php echo $category2->ID; ?>">
                                                        <?php echo $category2->name; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('parentCategory'); ?></span>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                    <div class="col-md-4"></div>
                                </div>

                            </div>
                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('categories'); ?>" class="btn btn-warning mr-1">
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
