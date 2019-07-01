@extends('admin/booth-detail')
@section('content2')	
	{{-- home --}}
	<div class="card border shadow-none">
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
			<h4><b><span class="fas fa-handshake text-warning"></span>&nbsp; INFORMASI JENIS TRANSAKSI</b></h4>
			<div class="separator-solid"></div>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th>No.</th>
						<th>Jenis Transaksi</th>
						<th>Pajak</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					@php
						$a = 1;
					@endphp
					@foreach ($jenis as $j)
					<tr>
						<td>{{$a++}}</td>
						<td>{{$j->jenis_transaksi}}</td>
						@if ($j->pajak == 0)
							<td>-</td>
						@else
							<td>{{$j->pajak}} %</td>
						@endif
						@if ($j->status == 1)
							<td>Aktif</td>
						@else
							<td>Non-Aktif</td>
						@endif

						@if ($j->status == 1)
							@if ($booth->status != 1)
								<td>
									<a href="/admin/booth/booth-pawonlijo/transaksi/{{$j->id}}/0" class="btn btn-xs btn-warning disabled">Non-aktifkan</a>
								</td>
							@else
								<td>
									<a href="/admin/booth/booth-pawonlijo/transaksi/{{$j->id}}/0" class="btn btn-xs btn-warning">Non-aktifkan</a>
								</td>
							@endif
							
						@else
							@if ($booth->status != 1)
								<td><a href="/admin/booth/booth-pawonlijo/transaksi/{{$j->id}}/1" class="btn btn-xs btn-success disabled">Aktifkan</a></td>
							@else
								<td><a href="/admin/booth/booth-pawonlijo/transaksi/{{$j->id}}/1" class="btn btn-xs btn-success">Aktifkan</a></td>
							@endif
							
						@endif
					</tr>
					@endforeach
				</table>
			</div>
			<br>
			<h4><b><span class="fas fa-chalkboard-teacher text-warning"></span>&nbsp; INFORMASI PEGAWAI</b></h4>
			<div class="separator-solid"></div>
			<div class="table-responsive">
				@php
					$i = 1;
				@endphp
				@if ($jumlah_kasir > 0)
					@foreach ($kasirs as $kasir)
						<table class="table table-striped">
							<tr>
								<td width="20%">Nama Pegawai {{$i++}}</td>
								<td width="1%">:</td>
								<td>{{$kasir->nama_kasir}}</td>
							</tr>
							<tr>
								<td>Alamat Pegawai</td>
								<td>:</td>
								<td>{{$kasir->alamat_kasir}}</td>
							</tr>
							<tr>
								<td>Nomor Telp. Pegawai</td>
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
	<div class="modal fade bd-example-modal-sm mt-4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form action="{{ route('admin.pajak-booth-transaksi') }}" method="POST">
	    			@csrf
		      		<div class="modal-header">
				        <h5 class="modal-title">Edit Transaksi</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <div class="modal-body">
				        <div class="form-group">
				        	<label for="">Nama Transaksi</label>
				        	<input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi" value="" readonly>
				        	<input type="hidden" class="form-control" name="id" id="id_jenis" value="">
				        </div>
				        <div class="form-group">
				        	<label for="">Pajak</label>
				        	<input type="number" min="0" class="form-control" name="pajak" id="pajak" value="">
				        </div>
				    </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				        <input type="submit" class="btn btn-primary btn-sm" name="batal" value="Update">
				    </div>
			    </form>
	    	</div>
	  	</div>
	</div>

@endsection



