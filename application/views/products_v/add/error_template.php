<?php foreach ($errors as $error) { ?>
	<div class="alert bg-danger alert-dismissible mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<?php echo $error; ?>
	</div>

<?php } ?>
