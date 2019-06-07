<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Nota</title>
	<style>
		@page{ 
			size: 164pt {{(5*30)+(count($detail)*2*35)+(280)}}pt;
			margin: 0;
		}
		@if (Request::segment(2) == 'nota')
			a{
				visibility: hidden;
			}
		@endif
	</style>
</head>
<body>
	<div class="container" style="padding: 1.5mm; width: 53mm;">
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
				<tr style="height: 20px">
					@foreach ($produk as $p)
						@if($d->id_produk == $p->id)
							<td colspan="3">{{$p->nama_makanan}}</td>
						@endif
					@endforeach
					
				</tr>
				<tr  style="height: 20">
					<td width="70px">Rp {{Rupiahd($d->harga_satuan)}}</td>
					<td width="40px" style="padding-bottom: 5px">x {{$d->jumlah}}</td>
					<td>Rp {{Rupiahd($d->harga_satuan*$d->jumlah)}}</td>
				</tr>
				@endforeach
				<tr>
					<td width="60%" colspan="2" style="padding-top: 20px">Subtotal</td>
					<td width="40%" style="padding-top: 20px">Rp {{Rupiahd($nota->subtotal)}}</td>
				</tr>
				<tr>
					<td width="60%" colspan="2">Potongan</td>
					<td width="40%">Rp {{Rupiahd($nota->potongan)}}</td>
				</tr>
				<tr >
					<td width="60%" colspan="2">Total</td>
					<td width="40%">Rp {{Rupiahd($nota->total)}}</td>
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
			<div class="" style="padding-top: 20px; border-top: 2px dashed black; height: 40px;">
				{{$nota->id}} <br>
				{{date('d/m/Y H:i',strtotime($nota->created_at))}}<br>
				{{$nota->jenis}} 
				{{$nota->kode != null ? '('.$nota->kode.')' : null}}
			</div>
			<div align="center" style="height: 40px; margin-top: 30px;">
				<p>Thank you {{$nota->nama_pembeli}}!</p>
			</div>
			<a href="{{ route('kasir.dashboard') }}"><button>Kembali</button></a>
			<a href="{{ route('kasir.nota',$nota->id) }}" target="_blank"><button>Cetak</button></a>
		</div>
	</div>
	
	
</body>
</html>