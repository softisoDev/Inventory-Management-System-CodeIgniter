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
                        <?php if(!$result){echo '<h1 class="red">Heç bir məlumat tapılmadı</h1>'; exit();}  ?>
                        <?php if($premix->netAmount != $premix->initialAmount){echo '<h1 class="red">Bu premix redaktə oluna bilməz!!!</h1>'; exit();} ?>
                        <form class="form" method="post" action="<?php echo base_url('premixes/update/').$premix->ID; ?>">
                            <div class="form-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="auto-code">Avtomatik Kod</label>
                                            <input type="text" readonly value="<?php echo $premix->autoCode; ?>" id="auto-code"
                                                   class="form-control border-primary" placeholder="Avtomatik Kod" name="auto-code">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('auto-code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Kodu</label>
                                            <input type="text" id="code" class="form-control border-primary" placeholder="Kodu" name="code" value="<?php echo $premix->code; ?>">
                                            <?php if(isset($form_error)): ?>
                                            <span class="font-italic red font-weight-bold"><?php echo form_error('code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="premix-name">Adı</label>
                                            <input type="text" id="premix-name" class="form-control border-primary" placeholder="Adı" name="premix-name" value="<?php echo $premix->name; ?>">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('premix-name'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!--  UNIT  -->
                                    <!--<div class="col-md-3">
                                        <div class="form-group">
                                            <label for="premix-unit">Ölçü Vahidi</label>
                                            <select readonly class="form-control border-primary" required name="premix-unit" id="premix-unit">
                                                <option value="">Ölçü Vahidi</option>
                                                <?php
/*                                                foreach ($units as $unit){ */?>
                                                    <option
                                                            <?php /*echo ($unit->ID==4)? "selected":"" */?>
                                                            value="<?php /*echo $unit->ID; */?>">
                                                        <?php /*echo $unit->name; */?>
                                                    </option>
                                               <?php /*} */?>
                                            </select>
                                            <?php /*if(isset($form_error)): */?>
                                                <span class="font-italic red font-weight-bold"><?php /*echo form_error('premix-unit'); */?></span>
                                            <?php /*endif; */?>
                                        </div>

                                    </div>-->

                                    <!--  WAREHOUSE  -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warehouse">Anbar </label>
                                            <select class="form-control border-primary" name="warehouse" id="warehouse">
                                                <option value="">Anbar</option>
                                                <?php
                                                foreach ($warehouses as $warehouse){
                                                    echo '<option value="'.$warehouse->ID.'">'.$warehouse->name.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('warehouse'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>

                                </div>

                            <hr>

                            <h3 class="text-center">Reçete İçeriği</h3>
                            <br/>

                            <input type="hidden" readonly id="last-tr-id" value="1">
                            <input type="hidden" readonly id="focused-tr-id" value="1">
                            <span class="pull-right pb-1">
                                <button onclick="addNewRow()" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Əlavə Et
                                </button>
                            </span>

                            <table id="added-items-list" class="table full-width table-responsive table-bordered">
                                <thead>
                                <tr>
                                    <th class="col-3">Kodu</th>
                                    <th class="col-4">Adı</th>
                                    <th class="col-1">Ölçü Vahidi</th>
                                    <th>Miqdarı</th>
                                    <th class="col-1">Nisbət</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php for ($i=0;$i<=(count($premixItems)-1);$i++){ ?>
                                <tr id="items-table-row-<?php echo $i+1; ?>">
                                    <td class="custom-product-td">
                                        <input type="text" required onfocus="addProduct(this)" name="product-code[]"  class="form-control custom-product-input mySearch product-code" value="<?php echo $premixItems[$i]->code; ?>">
                                        <input type="hidden" name="productID[]" class="productID" value="<?php echo $premixItems[$i]->pID; ?>">
                                        <input type="hidden" name="productWarehouse[]" class="productWarehouse"  value="<?php echo $premixItems[$i]->warehouseID; ?>">
                                    </td>
                                    <td class="custom-product-td">
                                        <input type="text" required name="product-name[]" readonly class="form-control custom-product-input" value="<?php echo $premixItems[$i]->title; ?>">
                                    </td>
                                    <td class="custom-product-td">
                                        <select name="product-unit[]" required  class="form-control custom-product-select product-unit" onchange="setUnitID2Input(this)">
                                            <option  value="">Ölçü Vahidi</option>
                                            <?php
                                            foreach ($units as $unit){ ?>
                                                <option
                                                        data-id="<?php echo $unit->ID; ?>"
                                                    <?php echo ($premixItems[$i]->unitID==$unit->ID)?"selected":""; ?>
                                                        value="<?php echo $unit->name;?>">
                                                    <?php echo $unit->name; ?>
                                                </option>
                                            <?php }
                                            ?>
                                        </select>
                                        <input value="<?php echo $premixItems[$i]->unitID; ?>" type="hidden" class="product-unit-db" name="product-unit-db[]" required>
                                    </td>
                                    <td class="custom-product-td">
                                        <fieldset>
                                            <div class="input-group">
                                                <input required type="text" name="product-quantity[]" class="form-control custom-product-input custom-touch-spin product-quantity general-touchspin sale-bill" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" onkeyup="calcRatio(this);" value="<?php echo $premixItems[$i]->amount; ?>" />
                                                <input value="<?php echo $premixItems[$i]->stockAmount; ?>" class="max-quantity" id="max-quantity" name="max-quantity" type="hidden">
                                            </div>
                                        </fieldset>
                                    </td>

                                    <td class="custom-product-td">
                                        <fieldset>
                                            <div class="input-group">
                                                <input value="<?php echo $premixItems[$i]->ratio; ?>" readonly type="number" step="1" name="product-ratio[]" class="form-control custom-product-input product-ratio"/>
                                            </div>
                                        </fieldset>
                                    </td>


                                    <td class="custom-product-td product-operation-td">
                                        <i onclick="removeRow(this)" data-belong-row-id="<?php echo $i+1; ?>" class="fa fa-trash red"></i>
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>

                            </table>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <strong>Cəm: </strong> <span id="premix-total-amount"><?php echo $premix->netAmount; ?></span> <span id="premix-total-unit">kg</span>
                                    <input value="<?php echo $premix->netAmount; ?>" required type="hidden" name="premix-total-amount">
                                </div>
                            </div>

                            </div>
                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('premixes'); ?>" class="btn btn-warning mr-1">
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
</section>
