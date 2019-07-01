<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	{{-- <style>
		.table{
			border-collapse: collapse;
		}
		.table th, .table td{
				padding: 0.5rem;
				font-size: 0.9rem;
				height: 1rem !important;
				border: 1px solid black;
				font-family: Arial, sans-serif;
			}
		.ringkasan th, .ringkasan td{
			font-size: 1rem;
		}
		.transaksi th{
			color: white;
		}
		.page-break {
		    page-break-after: always;
		}
		h3{
			margin-bottom: 0px;
			font-family: Arial,sans-serif;
		}
		h4{
			margin-top: 1%;
			font-family: Arial,sans-serif;
		}
	</style> --}}
</head>
<body>
	@if ($id_booth == null)
		<div class="col-md-11 mt--1">
			<h3><b>LAPORAN PENJUALAN SEMUA BOOTH PAWON LIJO</b></h3>
			@if ($akhir == '' || $akhir==$awal)
				<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}}</h4>
				
			@else
				<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}} - {{date('d/m/Y', strtotime($akhir))}}</h4>
			@endif
			
		</div>
	@else
		<div class="col-md-11 mt--1">
			<h3><b>LAPORAN PENJUALAN {{$nb->nama_booth}}, {{$nb->kota_booth}} (#{{$id_booth}})</b></h3>
			@if ($akhir == '' || $akhir==$awal)
				<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}}</h4>
				
			@else
				<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}} - {{date('d/m/Y', strtotime($akhir))}}</h4>
			@endif
		</div>
	@endif
	<table class="table table-bordered transaksi border" width="100%">
		<thead>
			<tr>
				<th>TANGGAL</th>
				<th>ID TRANSAKSI</th>
				<th>JENIS</th>
				<th>KODE</th>
				<th>SUBTOTAL</th>
				<th>PAJAK</th>
				<th>DISCOUNT</th>
				<th>TOTAL</th>
			</tr>
		</thead>
		<tbody>
			@php
				$total_b = 0;
			@endphp
			@foreach ($sales as $sale)
				
				<tr>
					<td>{{date('d/m/Y H:i',strtotime($sale->created_at))}}</td>
					<td>{{$sale->id}}</td>
					<td>{{$sale->jenis}}</td>
					@if($sale->kode != null)
					<td>{{$sale->kode}}</td>
					@else
					<td>-</td>
					@endif
					<td>Rp {{Rupiahd($sale->subtotal)}}</td>
					<td>Rp {{Rupiahd($sale->total_pajak)}}</td>
					<td>Rp {{Rupiahd($sale->potongan)}}</td>
					<td>Rp {{Rupiahd($sale->total_bersih)}}</td>
				</tr>
				<tr>
					<td>Detail : </td>
					<td>Nama Makanan </td>
					<td>Harga</td>
					<td>Jumlah</td>
					<td colspan="4"></td>
				</tr>
				@foreach ($detail as $d)
					@if($sale->id == $d->id_transaksi)
					<tr>
						<td></td>
						<td>{{$d->nama_makanan}}</td>
						<td>Rp {{Rupiahd($d->harga_satuan)}}</td>
						<td>{{$d->jumlah}}</td>
						<td colspan="4"></td>
					</tr>
					@endif
				@endforeach
				@php
				
					$total_b += $sale->total_bersih;
				@endphp
			@endforeach
			
		</tbody>
	</table>

	{{-- <h4>Ringkasan</h4>

	<table class="table table-bordered border ringkasan" width="100%">
		<tr>
			<th colspan="2">Produk Terjual</th>
		</tr>
		<tr>
			<th>Nama Produk</th>
			<th>Jumlah</th>
		</tr>
		@foreach ($pj as $p)
		<tr>
			<td>{{$p->nama_makanan}}</td>
			<td>{{$p->jumlah}} Porsi</td>
		</tr>
		@endforeach
	</table>

	<table class="table table-bordered border ringkasan" width="100%">
		<tr>
			<th colspan="4">total Pendapatan & pajak</th>
		</tr>
		<tr>
			<th>Jenis</th>
			<th>Transaksi</th>
			<th>Pajak</th>
			<th>Total Bersih</th>
		</tr>
		@php
			$pt = 0;
			$t = 0;
		@endphp
		@foreach ($pjk as $pk)
			<tr>
				<td>{{$pk->jenis}}</td>
				<td>{{$pk->trans}}</td>
				<td>Rp {{Rupiahd($pk->t_pajak)}}</td>
				<td>Rp {{Rupiahd($pk->total_b)}}</td>

			</tr>
			@php
				$pt += $pk->t_pajak;
				$t += $pk->trans
			@endphp
		@endforeach
		<tr>
			<th>Total</th>
			<th>{{$t}}</th>
			<th>
				Rp {{Rupiah($pt)}}
			</th>
			<th>
				Rp {{Rupiah($total_b)}}
			</th>

		</tr>									
	</table> --}}
</body>
</html>


