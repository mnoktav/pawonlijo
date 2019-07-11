<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nota</title>
	<link rel="stylesheet" href="{{ asset('assets/atlantis/css/bootstrap.min.css') }} ">
</head>
<body>
	<div class="container" style="padding: 3% 15%;">
		<div class="print">
			<div class="header" style="text-align: center;">
				<h3>Pawon Lijo</h3>
				<p>
					{{session('login')['nama_booth']}} <br>
					{{$booth->alamat_booth}}, {{$booth->kota_booth}}
				</p>
			</div>
			<div class="row" style="margin-bottom: 2%">
				<div class="col-md-4">
					{{$nota->id}} <br>
					{{date('d/m/Y H:i',strtotime($nota->created_at))}} 
				</div>
				<div class="col-md-4">
					
				</div>
				<div class="col-md-4">
					Jenis Transaksi : 
					{{$nota->jenis}} <br>
					{{$nota->kode != null ? '('.$nota->kode.')' : null}}
				</div>
			</div>
			<table class="table table-bordered" style="margin-bottom: 20px;">
				@foreach ($detail as $d)
			
				<tr>
					@foreach ($produk as $p)
						@if($d->id_produk == $p->id)
							<th>{{$p->nama_makanan}}</th>
						@endif
					@endforeach
					<th width="">Rp {{Rupiahd($d->harga_satuan)}}</th>
					<th width="" style="padding-bottom: 5px">x {{$d->jumlah}}</th>
					<th>Rp {{Rupiahd($d->harga_satuan*$d->jumlah)}}</th>
				</tr>
				@endforeach
				<tr>
					<td width="" colspan="3">Subtotal</td>
					<td width="">Rp {{Rupiahd($nota->subtotal)}}</td>
				</tr>
				<tr>
					<td width="" colspan="3">Potongan</td>
					<td width="">Rp {{Rupiahd($nota->potongan)}}</td>
				</tr>
				<tr >
					<td width="" colspan="3">Total</td>
					<td width="">Rp {{Rupiahd($nota->total)}}</td>
				</tr>
				<tr>
					<td colspan="3" style="padding-top: 20px">Bayar</td>
					<td style="">Rp {{Rupiahd($nota->bayar)}}</td>
				</tr>
				<tr>
					<td colspan="3">Kembali</td>
					<td>Rp {{Rupiahd($nota->kembali)}}</td>
				</tr>
			</table>
			<div class="row">
				<div class="col-md-12 text-center">
					<a class="btn btn-warning" href="{{ route('kasir.dashboard') }}">Kembali</a>
					<a class="btn btn-primary" href="{{ route('kasir.nota',$nota->id) }}" target="_blank">Cetak</a>
				</div>
			</div>
		</div>
	</div>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	@include('sweet::alert')
	
</body>
</html>