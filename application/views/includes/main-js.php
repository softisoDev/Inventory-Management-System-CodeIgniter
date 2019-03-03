<!-- BEGIN VENDOR JS-->
<script src="<?php echo base_url('app-assets');?>/vendors/js/vendors.min.js" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->

<!-- BEGIN MODERN JS-->
<script src="<?php echo base_url('app-assets'); ?>/js/core/app-menu.js" type="text/javascript"></script>
<script src="<?php echo base_url('app-assets'); ?>/js/core/app.js" type="text/javascript"></script>
<script src="<?php echo base_url('app-assets'); ?>/js/scripts/customizer.js" type="text/javascript"></script>
<!-- END MODERN JS-->

<!--  Switch Buttons  -->
<script src="<?php echo base_url('app-assets'); ?>/vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>

<!--  BEGIN TOASTR  -->
<script src="<?php echo base_url('app-assets'); ?>/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url('app-assets'); ?>/js/core/runToastr.js" type="text/javascript"></script>

<?php
$alert = $this->session->userdata('alert');
if($alert): ?>
    <script>
        <?php if(isset($alert['position'])): ?>
        runToastr("<?php echo $alert['title']; ?>","<?php echo $alert['text']; ?>","<?php echo $alert['type']; ?>","<?php echo $alert['position']; ?>");
        <?php else: ?>
        runToastr("<?php echo $alert['title']; ?>","<?php echo $alert['text']; ?>","<?php echo $alert['type']; ?>");
        <?php endif; ?>
    </script>
<?php endif; ?>

<!--  END TOASTR  -->


<!--  BEGIN SWEET ALERT  -->
<script src="<?php echo base_url('app-assets'); ?>/vendors/js/extensions/sweetalert.min.js" type="text/javascript"></script>
<!--  END SWEET ALERT  -->

<!--  BEGIN CUSTOM JS  -->
<script src="<?php echo base_url('app-assets'); ?>/js/core/custom.js" type="text/javascript"></script>
<!--  END CUSTOM JS  -->

<!--  BEGIN SKYCONS  -->
<script src="https://rawgithub.com/darkskyapp/skycons/master/skycons.js"></script>

<script type="text/javascript">
    var icons = new Skycons({"color": "white"});
    icons.set("clear-day", Skycons.CLEAR_DAY);
    icons.play();
</script>
<!--  END SKYCONS  -->