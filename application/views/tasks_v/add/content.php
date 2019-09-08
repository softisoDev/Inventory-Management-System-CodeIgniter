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

                        <form id="task-form" class="form" method="post" action="<?php echo base_url('tasks/save'); ?>">
                            <div class="form-body">

                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="input-group">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="auto-code">Avtomatik Kod</label>
                                                    <input type="text" required readonly value="<?php echo $newCode; ?>" id="auto-code"
                                                           class="form-control border-primary" placeholder="Avtomatik Kod" name="auto-code">
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('auto-code'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="task-name">Adı</label>
                                                    <input type="text" id="task-name" class="form-control border-primary" placeholder="Task Adı" name="task-name" required>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('task-name'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">Başlanğıc tarixi</label>
                                                    <input value="<?php echo date('Y-m-d'); ?>" type="text" required id="startDate" class="form-control border-primary date" placeholder="Tarix" name="startDate">
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('date'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date">Bitiş tarixi</label>
                                                    <input type="text" required id="endDate" class="form-control border-primary date" placeholder="Bitiş tarixi" name="endDate">
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('date'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="machine">Makinalar</label>
                                                    <select required class="select2 form-control border-primary" name="machine" id="machine">
                                                        <option value="">Makina Seç</option>
                                                        <?php
                                                        foreach ($machines as $machine){
                                                            echo '<option value="'.$machine->ID.'">'.$machine->name.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('recipe'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="task-name">Ortalama MC</label>
                                                    <input type="text" id="machine-mc" class="form-control border-primary" placeholder="MC" name="machine-mc" required>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('"machine-mc'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="task-name">Siqaret tipi</label>
                                                    <select required class="select2 form-control border-primary" name="cigaretteType" id="cigaretteType" required>
                                                        <option value="">Siqaret tipi</option>
                                                        <?php
                                                        foreach ($cigarettes as $cigarette){
                                                            echo '<option  
                                                            data-unit-id     = "'.$cigarette->unitID.'"
                                                            data-exp-tobacco = "'.$cigarette->expTobac.'" 
                                                            value="'.$cigarette->ID.'"
                                                            >
                                                            '.$cigarette->name.'
                                                            </option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('recipe'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="planDay">Tütün miqdarı: </label>
                                                    <input type="number" min="1" step="0.01" readonly id="expTobac" class="form-control border-primary" placeholder="Tütün miqdarı" name="expTobac" required>
                                                    <input required type="hidden" name="tobacUnitID" id="tobacUnitID">
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('expTobac'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="input-group">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="task-name">Reçete</label>
                                                    <select required class="select2 form-control border-primary" name="recipe" id="recipe" required>
                                                        <option value="">Reçete seç</option>
                                                        <?php
                                                        foreach ($recipes as $recipe){
                                                            echo '<option value="'.$recipe->ID.'">'.$recipe->title.'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('recipe'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="task-name">Qeyd</label>
                                                    <textarea class="form-control form-bordered" name="description" id="description"></textarea>
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('description'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-6" id="resultMessages">

                                    </div>
                                </div>

                            </div>

                            <div class="form-actions text-center">
                                <a href="<?php echo base_url('tasks'); ?>" class="btn btn-warning mr-1">
                                    <i class="ft-x"></i> Ləğv Et
                                </a>
                                <button onclick="calculateTask()" type="button" class="btn btn-success">
                                    <i class="la la-calculator"></i> Hesabla
                                </button>
                                <button id="saveButton" type="submit" class="btn btn-primary">
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
