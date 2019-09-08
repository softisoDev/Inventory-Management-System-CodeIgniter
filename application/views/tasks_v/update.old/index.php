<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/main-style"); ?>
    <?php $this->load->view("{$viewFolder}/{$subViewFolder}/pageStyle"); ?>

    <style>
        .select2 {
            width:100%!important;
        }
    </style>

</head>
<body class="vertical-layout vertical-compact-menu 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-compact-menu" data-col="2-columns">

<?php $this->load->view("includes/top-head"); ?>
<?php $this->load->view("includes/aside"); ?>

<div class="app-content content">
    <div class="content-wrapper">
        <?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
    </div>
</div>


<?php $this->load->view("includes/footer"); ?>
<?php $this->load->view("includes/main-js"); ?>
<?php $this->load->view("{$viewFolder}/{$subViewFolder}/pageScript"); ?>
<script>

    $(document).ready(function () {
        $(".select2").each(function () {
           $(this).select2({
               language:{
                   noResults:function(){return"Nəticə yoxdur"}
               }
           });
        });

        $("#vat").TouchSpin({
            min: 0,
            max: 100,
            step: 0.5,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
         $(".costs").TouchSpin({
            min: 0,
            step: 0.01,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: 'AZN'
         });

        $("#critic-amount").TouchSpin({
            min: 0,
            step: 1,
            boostat: 5,
            maxboostedstep: 10,
        });

    });
</script>
</body>
</html>

