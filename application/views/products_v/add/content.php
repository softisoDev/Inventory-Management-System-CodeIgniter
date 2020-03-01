<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <h3 class="content-header-title mb-0"><?php echo $header; ?></h3>
    </div>
</div>

<section id="horizontal-vertical">
    <div class="row">
        <div class="col-12">
            <div class="card">
				<!-- Card header start -->
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

				<!-- Cart content start -->
				<div class="card">
					<div class="card-content">
						<div class="card-body">
							<!-- Tab headers start -->
							<ul class="nav nav-tabs nav-linetriangle no-hover-bg">
								<li class="nav-item">
									<a class="nav-link active" id="manual-import-tab" data-toggle="tab" aria-controls="manual-import" href="#manual-import"
									   aria-expanded="true">Manüel giriş</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="file-import-tab" data-toggle="tab" aria-controls="from-file-import" href="#from-file-import"
									   aria-expanded="false">Dosyadan giriş</a>
								</li>
							</ul>
							<!-- Tab content start -->
							<div class="tab-content px-1 pt-1">

								<!-- Manual import tab start -->
								<div role="tabpanel" class="tab-pane active" id="manual-import" aria-expanded="true" aria-labelledby="manual-import-tab">
									<form class="form" method="post" action="<?php echo base_url('products/save'); ?>">
										<div class="form-body">
											<h4 class="form-section"><i class="la la-cube"></i> Əsas Sahələr</h4>
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
														<label for="product-name">Adı</label>
														<input type="text" id="product-name" class="form-control border-primary" placeholder="Adı" name="product-name">
														<?php if(isset($form_error)): ?>
															<span class="font-italic red font-weight-bold"><?php echo form_error('product-name'); ?></span>
														<?php endif; ?>
													</div>
												</div>

												<div class="col-md-3">
													<div class="form-group">
														<label for="brand">Marka </label><span class="pull-right">+ Əlavə Et</span>
														<select class="select2 form-control border-primary" name="brand" id="brand">
															<option value="">Marka</option>
															<?php
															foreach ($brands as $brand){
																echo '<option value="'.$brand->ID.'">'.$brand->name.'</option>';
															}
															?>
														</select>
														<?php if(isset($form_error)): ?>
															<span class="font-italic red font-weight-bold"><?php echo form_error('brand'); ?></span>
														<?php endif; ?>
													</div>
												</div>

											</div>
											<div class="row">

												<div class="col-md-3">
													<div class="form-group">
														<label for="category">Kateqoriya</label>
														<select class="select2 form-control border-primary" name="category" id="category">
															<option value="">Kateqoriya</option>
															<?php
															foreach ($categories as $category){
																echo '<option value="'.$category->ID.'">'.$category->name.'</option>';
															}
															?>
														</select>
														<?php if(isset($form_error)): ?>
															<span class="font-italic red font-weight-bold"><?php echo form_error('category'); ?></span>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="projectinput4">Ölçü Vahidi</label>
														<select class="select2 form-control border-primary" name="unit" id="unit">
															<option value="">Ölçü Vahidi</option>
															<?php
															foreach ($units as $unit){
																echo '<option value="'.$unit->ID.'">'.$unit->name.' ('.$unit->shortName.')</option>';
															}
															?>
														</select>
														<?php if(isset($form_error)): ?>
															<span class="font-italic red font-weight-bold"><?php echo form_error('unit'); ?></span>
														<?php endif; ?>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="critic-amount">Kritik Stok Miqdarı</label>
														<fieldset>
															<div class="input-group">
																<input name="critic-amount" id="critic-amount" type="text" class="" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
															</div>
														</fieldset>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="shelf-no">Rəf &#8470;</label>
														<input type="text" id="shelf-no" class="form-control border-primary" placeholder="Rəf &#8470;" name="shelf-no">
													</div>
												</div>

											</div>

											<h4 class="form-section"><i class="la la-paperclip"></i> Digər</h4>

											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label for="cost">Alış Qiyməti</label>
														<fieldset>
															<div class="input-group">
																<input name="cost" id="cost" type="text" class=" border-primary costs" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
															</div>
														</fieldset>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="price-1">Satış Qiyməti-1</label>
														<fieldset>
															<div class="input-group">
																<input name="price-1" id="price-1" type="text" class=" border-primary costs" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
															</div>
														</fieldset>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="price-2">Satış Qiyməti-2</label>
														<fieldset>
															<div class="input-group">
																<input name="price-2" id="price-2" type="text" class=" border-primary costs" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
															</div>
														</fieldset>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="vat">ƏDV</label>
														<fieldset>
															<div class="input-group">
																<input name="vat" id="vat" type="text" class="border-primary" data-bts-button-down-class="btn btn-info" data-bts-button-up-class="btn btn-info" />
															</div>
														</fieldset>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label for="barcode-1">Barkod-1</label>
														<input type="text" id="barcode-1" class="form-control border-primary" placeholder="Barkod-1" name="barcode-1">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="barcode-2">Barkod-2</label>
														<input type="text" id="barcode-2" class="form-control border-primary" placeholder="Barkod-2" name="barcode-2">
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label for="changable-code">Dəyişən Kodu</label>
														<input type="text" id="changable-code" class="form-control border-primary" placeholder="Dəyişən Kodu" name="changable-code">
													</div>
												</div>

											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="special-1">Xüsusi Sahə-1</label>
														<input type="text" id="special-1" class="form-control border-primary" placeholder="Xüsusi Sahə-1" name="special-1">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label for="special-2">Xüsusi Sahə-2</label>
														<input type="text" id="special-2" class="form-control border-primary" placeholder="Xüsusi Sahə-2" name="special-2">
													</div>
												</div>

											</div>

											<div class="row">

												<div class="col-md-12">
													<div class="form-group">
														<label for="description">Açıqlama</label>
														<textarea id="description" rows="5" class="form-control" name="description" placeholder="Açıqlama"></textarea>
													</div>
												</div>


											</div>

										</div>
										<div class="form-actions text-center">
											<a href="<?php echo base_url('products'); ?>" class="btn btn-warning mr-1">
												<i class="ft-x"></i> Ləğv Et
											</a>
											<button type="submit" class="btn btn-primary">
												<i class="la la-check-square-o"></i> Saxla
											</button>
										</div>
									</form>
								</div>

								<!-- File import tab -->
								<div class="tab-pane" id="from-file-import" aria-labelledby="file-import-tab">

									<div class="row">
										<div class="col-md-12 col-lg-12 text-center" id="error-area"></div>
									</div>

									<div class="row">
										<div class="col-md-12 col-lg-12 text-center" id="file-import-result-area"></div>
									</div>

									<div class="row">
										<div class="col-md-4 col-lg-4"></div>
										<div class="col-md-4 col-lg-4">

											<form class="form" method="post" id="from-file-form" enctype="multipart/form-data" action="<?php echo base_url('products/save-from-file')?>">

												<!-- Brand input -->
												<div class="form-group">
													<label for="brand">Marka</label>
													<select required class="select2 form-control border-primary" name="import-brand" id="import-brand">
														<option value="">Marka</option>
														<?php
														foreach ($brands as $brand){
															echo '<option value="'.$brand->ID.'">'.$brand->name.'</option>';
														}
														?>
													</select>
												</div>

												<!-- Category input -->
												<div class="form-group">
													<label for="category">Kateqoriya</label>
													<select required class="select2 form-control border-primary" name="import-category" id="import-category">
														<option value="">Kateqoriya</option>
														<?php
														foreach ($categories as $category){
															echo '<option value="'.$category->ID.'">'.$category->name.'</option>';
														}
														?>
													</select>
												</div>

												<!-- Unit input -->
												<div class="form-group">
													<label for="projectinput4">Ölçü Vahidi</label>
													<select required class="select2 form-control border-primary" name="import-unit" id="import-unit">
														<option value="">Ölçü Vahidi</option>
														<?php
														foreach ($units as $unit){
															echo '<option value="'.$unit->ID.'">'.$unit->name.' ('.$unit->shortName.')</option>';
														}
														?>
													</select>
												</div>

												<!-- File input -->
												<div class="form-group">
													<input required type="file" accept=".csv, text/csv, text/plain" name="csvFile" id="csvFile" class="form-control">
												</div>

												<!-- Submit button -->
												<div class="form-group text-center">
													<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Əlavə et</button>
												</div>

											</form>

										</div>
										<div class="col-md-4 col-lg-4"></div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>

            </div>
        </div>
    </div>
</section>
