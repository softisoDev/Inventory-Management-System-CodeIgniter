<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
	<?php $this->load->view("includes/head"); ?>
	<?php $this->load->view("includes/main-style"); ?>
	<style>
		.table th, .table td {
			padding: 0 !important;
		}
	</style>
</head>
<body style="background-color: white !important; color: black !important;">

<div class="app-content content">
	<div class="content-wrapper">
		<?php $this->load->view("{$viewFolder}/{$subViewFolder}/content"); ?>
	</div>
</div>


<?php $this->load->view("includes/footer"); ?>
<?php $this->load->view("includes/main-js"); ?>

<script>
	function printInvoice() {
		let printContent = document.getElementById('printableDiv').innerHTML;
		let originalContents = document.body.innerHTML;
		document.body.innerHTML = printContent;
		window.print();
		document.body.innerHTML = originalContents;
	}
</script>

</body>
</html>

