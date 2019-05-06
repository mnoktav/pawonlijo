<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nota</title>
	<style>
		@media print{
			.back {
			    display: none;
			 }
		}
	</style>
</head>
<body style="width: 100%" onload="window.print()">
	<div class="container" onload="" style="width: 219px; margin: 0 auto;">
		<div class="print">
			<div class="header" style="text-align: center;">
				<h3>Pawon Lijo</h3>
				<p style="margin-top: -1%; padding-bottom: 20px; border-bottom: 2px dashed black; font-size: 13px;">
					{{session('login')['nama_booth']}} <br>
					{{$booth->alamat_booth}}, {{$booth->kota_booth}}
				</p>
			</div>

			<table style="margin-bottom: 20px;">
				@foreach ($detail as $d)
				<tr>
					@foreach ($produk as $p)
						@if($d->id_produk == $p->id)
							<td colspan="3">{{$p->nama_makanan}}</td>
						@endif
					@endforeach
					
				</tr>
				<tr>
					<td width="80px">Rp {{Rupiahd($d->harga_satuan)}}</td>
					<td width="50px" style="padding-bottom: 5px">x {{$d->jumlah}}</td>
					<td>Rp {{Rupiahd($d->harga_satuan*$d->jumlah)}}</td>
				</tr>
				@endforeach
				<tr>
					<td width="60%" colspan="2" style="padding-top: 20px">Subtotal</td>
					<td width="40%" style="padding-top: 20px">Rp {{Rupiahd($nota->subtotal)}}</td>
				</tr>
				<tr >
					<td width="60%" colspan="2">Potongan</td>
					<td width="40%">Rp {{Rupiahd($nota->potongan)}}</td>
				</tr>
				<tr >
					<td width="60%" colspan="2"><b>Total</b></td>
					<td width="40%"><b>Rp {{Rupiahd($nota->total)}}</b></td>
				</tr>
				<tr>
					<td colspan="2" style="padding-top: 20px">Bayar</td>
					<td style="padding-top: 20px">Rp {{Rupiahd($nota->bayar)}}</td>
				</tr>
				<tr>
					<td colspan="2">Kembali</td>
					<td>Rp {{Rupiahd($nota->kembali)}}</td>
				</tr>
			</table>
			<div class="" style="padding-top: 20px; border-top: 2px dashed black;">
				{{$nota->id}} <br>
				{{date('d/m/Y H:i',strtotime($nota->created_at))}}
			</div>
			<div align="center">
				<p>Thank you {{$nota->nama_pembeli}}!</p>
			</div>
		</div>
		<a type="button" href="{{ route('kasir.dashboard') }}" class="back" style="margin-top: 20px">kembali</a>
	</div>
	
	
</body>
</html>