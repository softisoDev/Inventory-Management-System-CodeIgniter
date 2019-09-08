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
                        <form class="form" method="post" action="<?php echo base_url('purchases/save'); ?>">
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-paperclip"></i> Əsas Sahələr</h4>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="auto-code">Avtomatik Kod</label>
                                            <input type="text" required readonly value="<?php echo $newCode; ?>" id="auto-code"
                                                   class="form-control border-primary" placeholder="Avtomatik Kod" name="auto-code">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('auto-code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="code">Kodu</label>
                                            <input type="text" required id="code" class="form-control border-primary" placeholder="Kodu" name="code">
                                            <?php if(isset($form_error)): ?>
                                            <span class="font-italic red font-weight-bold"><?php echo form_error('code'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="warehouse">Anbar </label><span class="pull-right">+ Əlavə Et</span>
                                            <select class="select2 form-control border-primary" required name="warehouse" id="warehouse">
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

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="supplier">Tədarükçü Firma/Şəxs </label><span class="pull-right">+ Əlavə Et</span>
                                            <select class="select2 form-control border-primary" required name="supplier" id="supplier">
                                                <option value="">Tədarükçü Firma/Şəxs</option>
                                                <?php
                                                foreach ($suppliers as $supplier){
                                                    echo '<option value="'.$supplier->ID.'">'.$supplier->fullName.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('supplier'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="billType">Əməliyyat Tipi</label>
                                            <select class="select2 form-control border-primary" required name="billType" id="billType">
                                                <option value="">Əməliyyat Tipi</option>
                                                <?php
                                                foreach ($billTypes as $billType){
                                                    echo '<option value="'.$billType->ID.'">'.$billType->name.'</option>';
                                                }
                                                ?>
                                            </select>
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('billType'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="currency">Məzənnə</label>
                                            <select class="select2 form-control border-primary" required name="currency" id="currency">
                                                <option value="">Məzənnə</option>
                                                <?php
                                                foreach ($currency as $curr){ ?>
                                                    <option
                                                        <?php echo ($curr->name=="AZN") ? "selected":""; ?>
                                                            value="<?php echo $curr->symbol; ?>">
                                                        <?php echo $curr->name; ?> (<?php echo $curr->symbol; ?>)
                                                    </option>';
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">Tarix</label>
                                            <input value="<?php echo date('Y-m-d'); ?>" type="text" required id="date" class="form-control border-primary" placeholder="Tarix" name="date">
                                            <?php if(isset($form_error)): ?>
                                                <span class="font-italic red font-weight-bold"><?php echo form_error('date'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset class="form-group">
                                            <label for="requisition">Tələbnamə &#8470</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control border-primary" id="search-requisition" name="search-requisition" />
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ft-search"></i></span>
                                                </div>
                                                <input type="hidden" class="form-control border-primary" value="" id="requisition" name="requisition" />
                                            </div>
                                        </fieldset>
                                    </div>

                                </div>

                                <!--<h4 class="form-section"><i class="la la-cubes"></i>Məhsullar</h4>-->

                                <ul class="nav nav-tabs nav-linetriangle">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="baseIcon-tab31" data-toggle="tab" aria-controls="tabIcon31"
                                           href="#tabIcon31" aria-expanded="true"><i class="la la-cubes"></i> Məhsullar</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="baseIcon-tab32" data-toggle="tab" aria-controls="tabIcon32"
                                           href="#tabIcon32" aria-expanded="false"><i class="fa fa-info-circle"></i> Faktura Detalları</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="baseIcon-tab33" data-toggle="tab" aria-controls="tabIcon33"
                                           href="#tabIcon33" aria-expanded="false"><i class="la la-pencil"></i> Qeyd</a>
                                    </li>
                                </ul>

                                <div class="tab-content px-1 pt-1">
                                    <div role="tabpanel" class="tab-pane active" id="tabIcon31" aria-expanded="true"
                                         aria-labelledby="baseIcon-tab31">
                                        <div class="row">
                                            <div class="col-md-12">
                                        <span class="pull-left">
                                            <input type="hidden" readonly id="last-tr-id" value="1">
                                            <input type="hidden" readonly id="focused-tr-id" value="1">
                                        </span>
                                                <span class="pull-right pb-1">

                                            <label class="btn btn-info btn-sm mt-6px"><i class="fa fa-file"></i> Import from CSV
                			           	 		<input onChange="importFromCsv(this);" style="display:none;" 	type="file" name="csvFile" accept=".csv">
                			            	</label>

                                            <button onclick="addNewRow()" type="button" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Əlavə Et</button>
                                        </span>
                                                <table id="added-items-list" class="table full-width table-responsive table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="col-3">Kodu</th>
                                                        <th class="col-5">Adı</th>
                                                        <th class="col-1">Ölçü Vahidi</th>
                                                        <th>Miqdarı</th>
                                                        <th>Ədəd Qiyməti</th>
                                                        <th>Endirim (<span class="currency-indicator"></span>) ilə</th>
                                                        <th>Yekun Qiymət</th>
                                                        <th class="col-1"></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody id="product-list-content">
                                                    <tr id="items-table-row-1">
                                                        <td class="custom-product-td">
                                                            <input type="text" required onfocus="addProduct(this)" name="product-code[]"  class="form-control custom-product-input mySearch product-code">
                                                            <input type="hidden" name="productID[]" class="productID">
                                                            <!--<input type="hidden" name="productWarehouse[]" class="productWarehouse">-->
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <input type="text" required name="product-name[]" readonly class="form-control custom-product-input">
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <select name="product-unit[]" required  class="form-control custom-product-select product-unit">
                                                                <option value="">Ölçü Vahidi</option>
                                                                <?php
                                                                foreach ($units as $unit){
                                                                    echo '<option value="'.$unit->name.'">'.$unit->name.'</option>';
                                                                }
                                                                ?>
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <input onkeyup="calculateGrassTotal(this)" required type="text" name="product-quantity[]" type="text" class="form-control custom-product-input custom-touch-spin product-quantity general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
                                                                </div>
                                                            </fieldset>
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <input onkeyup="calculateGrassTotal(this)" required type="text" name="product-price[]" type="text" class="form-control custom-product-input custom-touch-spin product-price general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
                                                                </div>
                                                            </fieldset>
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <input type="text" onkeyup="applyDiscount(this)" name="product-discount[]" type="text" class="form-control custom-product-input custom-touch-spin product-discount general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
                                                                </div>
                                                            </fieldset>
                                                        </td>
                                                        <td class="custom-product-td">
                                                            <input type="text" name="product-grassTotal[]" required readonly class="form-control custom-product-input product-grassTotal">
                                                        </td>
                                                        <td class="custom-product-td product-operation-td">
                                                            <i onclick="removeRow(this)" data-belong-row-id="1" class="fa fa-trash red"></i>
                                                        </td>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabIcon32" aria-labelledby="baseIcon-tab32">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="special-1">Xüsusi Sahə-1</label>
                                                    <input type="text" id="special-1" class="form-control border-primary" placeholder="Xüsusi Sahə-1" name="special-1">
                                                </div>

                                                <div class="form-group">
                                                    <label for="special-2">Xüsusi Sahə-2</label>
                                                    <input type="text" id="special-2" class="form-control border-primary" placeholder="Xüsusi Sahə-2" name="special-2">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tabIcon33" aria-labelledby="baseIcon-tab33">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="note">Qeyd</label>
                                                    <div class="position-relative has-icon-left">
                                                        <textarea id="note" rows="5" class="form-control" name="note" placeholder="Qeyd"></textarea>
                                                        <div class="form-control-position">
                                                            <i class="fa fa-pencil"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <hr/>
                            <div class="row black">
                            <div class="col-md-12 text-right">
                                <p><strong>Yekun:</strong></p>
                            </div>
                                <div class="col-md-12 text-right">
                                    <p><strong>Cəm Məhsul Endirimi:</strong> <span id="totalProductDiscount"></span> <span class="currency-indicator">AZN</span></p>
                                    <input type="hidden" id="totalProductDiscount-input" required name="totalProductDiscount">
                                </div>

                                <!--  GENERAL DISCOUNT START  -->
                                <div class="col-md-4"></div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-right">
                                <div class="input-group">
                                    <label class="mtp-5 black"><strong>Ümumi Endirim (<span class="currency-indicator">₼</span>) ilə:</strong></label>
                                    <input type="text" onkeyup="calculateTotalDiscount()" name="generalDiscountValue" id="generalDiscountValue" type="text" class="form-control custom-product-input custom-touch-spin general-touchspin" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
                                </div>
                                </div>
                                <!--     GENERAL DISCOUNT END   -->

                                <div class="col-md-12 text-right mt-1">
                                    <p><strong>Cəm Endirim:</strong> <span id="totalDiscount"></span> <span class="currency-indicator">AZN</span></p>
                                    <input type="hidden" id="totalDiscount-input" required name="totalDiscount">
                                </div>

                                <div class="col-md-12 text-right mt-1">
                                    <p><strong>Yekun Qiymət:</strong> <span id="grandTotal"></span> <span class="currency-indicator">AZN</span></p>
                                    <input type="hidden" name="grandTotal" required id="grandTotal-input">
                                </div>

                            </div>

                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('purchases'); ?>" class="btn btn-warning mr-1">
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

