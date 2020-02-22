<div class="mt-2">
	<button class="btn btn-primary" onclick="printInvoice()">Print</button>
</div>
<hr>
<div id="printableDiv" style="width: 21cm !important; max-width: 21cm !important; padding-left: 5px !important;">

	<div class="row">
		<div class="col-md-4">
			<p><strong>Faktura kodu: </strong> <?php echo $sales->code; ?></p>
			<p contenteditable="true"><strong>Müştəri: </strong> <?php echo $sales->pFullName; ?></p>

		</div>
		<div class="col-md-4">
			<p><strong>Tarix: </strong> <?php echo $sales->date; ?></p>
			<p contenteditable="true"><strong>Əməliyyatçı: </strong> <?php echo $sales->bFullName; ?></p>
		</div>
		<div class="col-md-4 text-right">
			<img class="img img-responsive col-md-6" src="<?php echo base_url('app-assets'); ?>/images/cement-zavod.jpg">
		</div>

	</div>

	<div class="row">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th class="text-center">No</th>
				<th class="text-center">Məhsul kodu</th>
				<th class="text-center">Məhsulun adı</th>
				<th class="text-center">Ölç.Vahidi</th>
				<th class="text-center">Miqdar</th>
				<th class="text-center">Qiymət</th>
				<th class="text-center">Məbləğ</th>
			</tr>
			</thead>

			<tbody>
			<?php $i=0; ?>
			<?php foreach($salesItems as $item){ ?>
				<tr>
					<td class="text-center"><?php echo $i; ?></td>
					<td><?php echo $item->productCode; ?></td>
					<td><?php echo $item->productTitle; ?></td>
					<td class="text-center"><?php echo $item->productUnit; ?></td>
					<td class="text-center"><?php echo number_format($item->quantity, 2); ?></td>
					<td><?php echo $item->price . ' '. $item->currency; ?></td>
					<td><?php echo $item->grassTotal.' '.$item->currency; ?></td>
				</tr>
			<?php $i++; } ?>
			</tbody>

		</table>
	</div>

	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4"></div>
		<div class="col-md-4 text-right">
			<p><strong>Endirim: </strong><?php echo $sales->generalDiscount.' '.$sales->currency;?></p>
			<p><strong>ƏDV: </strong><?php echo $sales->totalVAT.' '.$sales->currency;?></p>
			<p><strong>Toplam: </strong><?php echo $sales->total.' '.$sales->currency;?></p>
		</div>
	</div>

	<div class="row mt-1">
		<div class="col-md-4">
			<p contenteditable="true"><strong>Təslim edən: </strong></p>
			<p><strong>İmza: </strong></p>
		</div>
		<div class="col-md-4">
			<p contenteditable="true"><strong>Təslim alan: </strong></p>
			<p><strong>İmza: </strong></p>
		</div>
		<div class="col-md-4 text-right">
		</div>
	</div>
</div>
