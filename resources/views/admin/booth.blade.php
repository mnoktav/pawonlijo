@extends('admin/master-d')
@section('css')
	<style>
		.nama_kasir{
			margin:0;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Booth PawonLijo</h4>
			<ul class="breadcrumbs">
				<li class="nav-home">
					<a href="{{ route('admin.dashboard') }}">
						<i class="flaticon-home"></i>
					</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Booth</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Booth PawonLijo</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="padding: 0;">
									<div class="input-icon">
										<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
										<span class="input-icon-addon">
											<i class="fa fa-search"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="row">
							@foreach ($booths as $booth)
							<div class="col-md-4 target">
								<div class="shadow-none card card-post card-round" style="border: 1px #cccccc solid; {{$booth->status == 0 ? 'background-color: #f2f2f2' : null }}">
									<div class="card-body">
										<div class="d-flex">
											<div class="avatar">
												@if($booth->status != 0)
													<span class="fas fa-store fa-2x mt-2" style="color: orange;"></span>
												@else
													<span class="fas fa-store fa-2x mt-2" style="color: grey;"></span>
												@endif
												
											</div>
											<div class="info-post ml-2">
												<p class="username">{{$booth->nama_booth}}</p>
												<p class="date text-muted">
													{{$booth->id_booth}}
													@if($booth->status == 0)
														(Nonaktif)
													@endif
												</p>
											</div>
										</div>
										<div class="separator-solid"></div>
										<div class="row">
											<div class="col-lg-6">	
												<h6><b>Alamat Booth : </b></h6>
												<p>{{$booth->alamat_booth}}</p>
												<h6><b>Jam Operasional : </b></h6>
												<p>{{date('H:i',strtotime($booth->jam_buka))}} - {{date('H:i',strtotime($booth->jam_tutup))}} WIB</p>
												
												<h6><b>Kasir : </b></h6>
												@php
													$i = 1;
												@endphp
												@foreach ($kasirs as $kasir)
												@if ($kasir->id_booth == $booth->id_booth)
													<p class="nama_kasir">{{$i++.'.'.' '.$kasir->nama_kasir}}</p>
												@endif
												@endforeach
											</div>
											<div class="col-lg-6">
												<h6><b>Trans. Sukses Hari Ini : </b></h6>
												<p>{{$ts[$booth->id_booth]}} Transaksi Sukses</p>
												<h6><b>Trans. Batal Hari Ini : </b></h6>
												<p>{{$tb[$booth->id_booth]}} Transaksi Batal</p>
												<h6><b>Pendapatan Hari Ini : </b></h6>
												<p>Rp {{$total[$booth->id_booth]}}</p>
											</div>
										</div>
										<div class="separator-solid"></div>
										<div class="text-center">
											<a href="{{ route('admin.detail-booth', $booth->id_booth) }}" class="btn btn-primary btn-rounded btn-sm">Detail Booth</a>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script>
		function Search() {
		  var input = document.getElementById("search");
		  var filter = input.value.toLowerCase();
		  var nodes = document.getElementsByClassName('target');

		  for (i = 0; i < nodes.length; i++) {
		    if (nodes[i].innerText.toLowerCase().includes(filter)) {
		      nodes[i].style.display = "block";
		    } else {
		      nodes[i].style.display = "none";
		    }
		  }
		}
	</script>
@endsection
