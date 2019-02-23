<!doctype html>
<html>
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/main-style"); ?>
    <style type="text/css">
        .img-float{
            float: left;
        }
        .card-img-top{
            height: 200px;
        }
        .controls-top{
            padding: 5px 10px;
        }
        .view-all-most-seller{
            padding-bottom: 15px;
            padding-right: 12px;
            vertical-align: middle;
        }
    </style>
</head>
<body class="vertical-layout vertical-compact-menu 2-columns   menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-compact-menu" data-col="2-columns">

<?php $this->load->view("includes/top-head"); ?>
<?php $this->load->view("includes/aside"); ?>

<div class="app-content content">
    <div class="content-wrapper">

    </div>
</div>


<?php $this->load->view("includes/footer"); ?>
<?php $this->load->view("includes/main-js"); ?>
</body>
</html>