<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/main-style"); ?>
    <?php $this->load->view("{$viewFolder}/pageStyle"); ?>
</head>
<body class="vertical-layout vertical-compact-menu 2-columns   menu-expanded fixed-navbar  pace-done" data-open="click" data-menu="vertical-compact-menu" data-col="2-columns"><div class="pace  pace-inactive"><div class="pace-progress" style="transform: translate3d(100%, 0px, 0px);" data-progress-text="100%" data-progress="99">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div></div>

<?php $this->load->view("{$viewFolder}/content"); ?>


<?php $this->load->view("includes/main-js"); ?>
<?php $this->load->view("{$viewFolder}/pageScript"); ?>

</body>
</html>

