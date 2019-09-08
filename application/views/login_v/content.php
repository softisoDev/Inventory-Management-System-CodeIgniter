<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1">
                                        <img height="30" width="100" src="<?php echo base_url('app-assets/images/logo/main-logo.png'); ?>" alt="branding logo">
                                    </div>
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3">
                                    <span>Giriş</span>
                                </h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <?php if(isset($wrongDetail) && $wrongDetail){echo '<h5 class="font-weight-bold font-italic red">İstfadəçi adı və ya şifrə yanlışdır!</h5>';} ?>

                                    <?php if(isset($form_error) && $form_error){echo '<h5 class="font-weight-bold font-italic red">İstfadəçi adı və ya şifrə boş buraxıla bilməz!</h5>';} ?>

                                    <form class="form-horizontal form-simple" action="<?php echo base_url('login-check'); ?>" novalidate method="post">
                                        <fieldset class="form-group position-relative has-icon-left mb-0">
                                            <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="İstifadəçi adı" name="user-name" required>
                                            <div class="form-control-position">
                                                <i class="ft-user"></i>
                                            </div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Parol" name="user-password" required>
                                            <div class="form-control-position">
                                                <i class="la la-key"></i>
                                            </div>
                                        </fieldset>
                                        <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> Giriş</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>