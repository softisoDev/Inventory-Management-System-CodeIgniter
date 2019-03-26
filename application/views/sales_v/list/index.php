<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/main-style"); ?>
    <?php $this->load->view("includes/dtStyle"); ?>
    <?php $this->load->view("{$viewFolder}/{$subViewFolder}/pageStyle"); ?>
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
<?php $this->load->view("includes/dtScript"); ?>
<?php $this->load->view("{$viewFolder}/{$subViewFolder}/pageScript"); ?>

</body>
</html>

