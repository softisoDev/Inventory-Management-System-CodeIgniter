$(document).ready(function () {
	$(".select2").each(function () {
		$(this).select2({
			language: {
				noResults: function () {
					return "Nəticə yoxdur"
				}
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

function submitForm() {
	let form = document.getElementById('from-file-form');
	$.ajax({
		url: app.host + 'products/save-from-file',
		type: "POST",
		beforeSend: function () {
			$.blockUI({message: '<h1>Gözləyin...</h1>'});
		},
		processData: false,
		contentType: false,
		cache: false,
		dataType: "JSON",
		data: new FormData(form),
		success: function (response) {
			console.log(response);

			if (!response.success && ('form_validation' in response)) {
				$('#error-area').empty().html(response.message);
			} else if (!response.success) {
				$('#error-area').empty().html(response.message);
			} else if (response.success) {
				$('#file-import-result-area').empty().html(response.message);
				document.getElementById('from-file-form').reset();
			} else {
				sweet_error();
			}
		},
		error: function (response) {
			console.log(response);
		},
		complete: function () {
			$.unblockUI();
		}
	});
}

$('#from-file-form').on('submit', function (event) {
	event.preventDefault();
	submitForm();
});
