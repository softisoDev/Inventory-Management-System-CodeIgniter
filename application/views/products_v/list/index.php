<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <?php $this->load->view("includes/head"); ?>
    <?php $this->load->view("includes/main-style"); ?>
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
<?php $this->load->view("{$viewFolder}/{$subViewFolder}/pageScript"); ?>
<script>
    var drawTable = $('.scroll-horizontal-vertical').DataTable( {
        "language": {
            "url": app.host+"app-assets/vendors/js/tables/datatable/locale/Azerbaijan.json",
            buttons: {
                copyTitle: 'Kopyalandı',
                copySuccess: {
                    _: '%d Sətir Kopyalandı',
                    1: '1 Sətir Kopyalandı'
                }
            }
        },
        "lengthMenu":[10, 18, 25, 50,100, "Hamısı"],
        "scrollY": "150vh",
        "responsive": true,
        "scrollX": true,
        "pageLength": 18,
        /*"serverSide": true,
        "processing": true,
        "ajax": {
            url: app.host+"products/getProductsTable",
            type:"POST"
        },*/
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            {
                extend: 'colvis',
                text:   "Sütunlar"
            }
        ],
        select: true,
        /*fixedHeader: {
            header: true,
            headerOffset: $('.header-navbar').outerHeight()
        }*/
    });
    /*if ($('body').hasClass('vertical-layout')) {
        var menuWidth = $('.main-menu').outerWidth();
        $('.fixedHeader-floating').css('margin-left',menuWidth+'px');
    }*/
    drawTable.columns.adjust();
</script>
</body>
</html>