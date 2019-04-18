@extends('admin/booth-detail')
@section('content2')	
	{{-- home --}}
		<div class="card" style="border: 1px solid #dddddd;">
			<div class="card-body">
				<h4><b><span class="fas fa-info-circle text-warning"></span>&nbsp; INFORMASI BOOTH</b></h4>
				<div class="separator-solid"></div>
				<div class="table-responsive">
					<table class="table table-striped" style="padding: 0px !important;">
						<tr>
							<td width="20%">Nama Booth</td>
							<td width="1%">:</td>
							<td>{{$booth->nama_booth}}</td>
						</tr>
						<tr>
							<td>ID Booth</td>
							<td>:</td>
							<td>{{$booth->id_booth}}</td>
						</tr>
						<tr>
							<td>Alamat Booth</td>
							<td>:</td>
							<td>{{$booth->alamat_booth}}</td>
						</tr>
						<tr>
							<td>Jam Operasional</td>
							<td>:</td>
							<td>{{date('H:i',strtotime($booth->jam_buka))}} - {{date('H:i',strtotime($booth->jam_tutup))}} WIB</td>
						</tr>
						<tr>
							<td>Nomor Telephone</td>
							<td>:</td>
							<td>{{$booth->telepon_booth}}</td>
						</tr>
						<tr>
							<td>Username Booth</td>
							<td>:</td>
							<td>{{$booth->username_booth}}</td>
						</tr>
						<tr>
							<td>Password Booth</td>
							<td>:</td>
							<td>
								<div class="row">
									<div class="col-md-3">
										<input type="password" class="form-control" value="{{Crypt::decryptString($booth->password_booth)}}" readonly="" id="password">
									</div>
									<div class="col-md-1">
										<button class="btn btn-sm btn-primary btn-rounded  mt-1" onclick="LihatPassword()">Lihat</button>
									</div>
								</div>
								
							</td>
						</tr>
					</table>
				</div>
				<br>
				<h4><b><span class="fas fa-chalkboard-teacher text-warning"></span>&nbsp; INFORMASI KASIR</b></h4>
				<div class="separator-solid"></div>
				<div class="table-responsive">
					@php
						$i = 1;
					@endphp
					@if ($jumlah_kasir > 0)
						@foreach ($kasirs as $kasir)
							<table class="table table-striped">
								<tr>
									<td width="20%">Nama Kasir {{$i++}}</td>
									<td width="1%">:</td>
									<td>{{$kasir->nama_kasir}}</td>
								</tr>
								<tr>
									<td>Alamat Kasir</td>
									<td>:</td>
									<td>{{$kasir->alamat_kasir}}</td>
								</tr>
								<tr>
									<td>Nomor Telp. Kasir</td>
									<td>:</td>
									<td>{{$kasir->telp_kasir}}</td>
								</tr>
							</table>
						@endforeach
					@else
						<h4 align="center" class="mt-4 mb-4">Belum tersedia kasir untuk booth ini.</4>
					@endif
					
				</div>
			</div>
		</div>
	{{-- end home --}}

@endsection

