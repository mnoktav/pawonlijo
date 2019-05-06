@extends('kasir/master-d')
@section('content')
	<div class="page-inner">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-9">
						<h4 style="text-transform: uppercase;"><b>REPORT HARIAN {{session('login')['nama_booth']}}</b></h4>
					</div>
					<div class="col-md-3 text-right">
						<small class="ml-4">Update terakhir : 20:11 WIB</small>
					</div>
				</div>
				<div class="separator-solid"></div>
				<div class="table-responsive">
					<table class="table  table-bordered border">
						<tr>
							<th width="20%">Pemasukan</th>
							<td width="1%">:</td>
							<td colspan="2">Rp {{Rupiah($total)}} </td>
						</tr>
						<tr>
							<th>Transaksi Berhasil</th>
							<td>:</td>
							<td>{{$ts}} Transaksi</td>
						</tr>
						<tr>
							<th>Transaksi Batal</th>
							<td>:</td>
							<td>{{$tb}} Transaksi</td>
						</tr>
					</table>
					<table class="table table-striped table-bordered border">
						<tr>
							<th width="20%" class="bg-dark text-light" colspan="3">Produk Terjual</th>
						</tr>
						@php
							$i = 1;
						@endphp
						@if (count($jh) == null)
							<tr class="text-center">
								<td colspan="3">Belum Ada Produk terjual</td>
							</tr>
						@else
							@foreach ($jh as $jh)
								<tr>
									<td width="5%">{{$i++}}.</td>
									<td width="30%">{{$jh->nama_makanan}}</td>
									<td>{{$jh->jumlah}} Porsi</td>
								</tr>
							@endforeach
						@endif
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection