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

                        <?php if(!$result){echo "<h1 class='red font-weight-bold'>Məlumat tapılmadı!</h1>"; exit();} ?>

                        <section>
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-10">
                                    <form class="form" method="post" action="<?php echo base_url('tasks/add-task-log/').$task->ID;?>">
                                        <div class="input-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Task adı</label>
                                                    <input type="text" required readonly value="<?php echo $task->tName; ?>"  class="form-control border-primary" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Reçete adı</label>
                                                    <input type="text" required readonly value="<?php echo $task->title; ?>" class="form-control border-primary">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Makina adı</label>
                                                    <input type="text" required readonly value="<?php echo $task->mName; ?>" class="form-control border-primary">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Siqaret növü</label>
                                                    <input type="text" required readonly value="<?php echo $task->ctName; ?>"  class="form-control border-primary" >
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Tütün miqdarı</label>
                                                    <input type="text" required readonly value="<?php echo $task->expTobac; ?>"  class="form-control border-primary" >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Başlanğıc Tarixi</label>
                                                    <input type="text" required readonly value="<?php echo $task->startDate; ?>"  class="form-control border-primary" >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">Bitiş Tarixi</label>
                                                    <input type="text" required readonly value="<?php echo $task->endDate; ?>"  class="form-control border-primary" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="input-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date">Bugün</label>
                                                    <input value="<?php echo date('Y-m-d'); ?>" type="text" required id="today" class="form-control border-primary date" placeholder="Tarix" name="today">
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('today'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="auto-code">MC miqdarı</label>
                                                    <input type="number" name="dailyMC" id="dailyMC" required step="1" min="1" class="form-control border-primary" >
                                                    <?php if(isset($form_error)): ?>
                                                        <span class="font-italic red font-weight-bold"><?php echo form_error('dailyMC'); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <a class="btn btn-warning task-more-save-btn white"><i class="ft-x"></i> Ləğv et</a>
                                                <button type="submit" class="btn btn-info task-more-save-btn"><i class="la la-check-square-o"></i> Saxla</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-md-1"></div>
                            </div>
                        </section>
                        <hr/>
                        <section class="cd-horizontal-timeline">
                            <div class="timeline">
                                <div class="events-wrapper">
                                    <div class="events">
                                        <ol>
                                            <?php
                                                $n = 1;
                                                foreach ($taskDetails as $detail){
                                                    if($n==1):
                                                        echo '<li><a href="#0" data-date="'.date('d/m/Y',strtotime($detail->logDate)).'" class="selected">'.date('d M', strtotime($detail->logDate)).'</a></li>';
                                                    else:
                                                        echo '<li><a href="#0" data-date="'.date('d/m/Y',strtotime($detail->logDate)).'">'.date('d M', strtotime($detail->logDate)).'</a></li>';
                                                    endif;
                                                    $n++;
                                                }
                                            ?>
                                            <!--<li><a href="#0" data-date="16/01/2015" class="selected">16 Jan</a></li>
                                            <li><a href="#0" data-date="17/01/2015">17 Feb</a></li>-->

                                        </ol>
                                        <span class="filling-line" aria-hidden="true"></span>
                                    </div>
                                    <!-- .events -->
                                </div>
                                <!-- .events-wrapper -->
                                <ul class="cd-timeline-navigation">
                                    <li><a href="#0" class="prev inactive">Prev</a></li>
                                    <li><a href="#0" class="next">Next</a></li>
                                </ul>
                                <!-- .cd-timeline-navigation -->
                            </div>
                            <!-- .timeline -->
                            <div class="events-content">
                                <ol>
                                    <?php
                                        $n = 0;
                                        foreach ($taskDetails as $detail){
                                            if($n==0){
                                                echo '<li class="selected" data-date="'.date('d/m/Y',strtotime($detail->logDate)).'">';
                                                echo '<h5 class="font-weight-bold">Hazırlanan MC miqdarı: <span class="font-weight-normal"> '.$detail->prepMC.'</span></h5>';
                                                echo '<p class="lead">'.$detail->content.'</p>';
                                                echo '</li>';
                                            }
                                            else{
                                                echo '<li data-date="'.date('d/m/Y',strtotime($detail->logDate)).'">';
                                                echo '<h5 class="font-weight-bold">Hazırlanan MC miqdarı: <span class="font-weight-normal"> '.$detail->prepMC.'</span></h5>';
                                                echo '<p class="lead">'.$detail->content.'</p>';
                                                echo '</li>';
                                            }
                                            $n++;
                                        }
                                    ?>
                                </ol>
                            </div>
                            <!-- .events-content -->
                        </section>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
