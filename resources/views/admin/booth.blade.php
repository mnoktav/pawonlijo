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
			<h4 class="page-title">Booth Pawon Lijo</h4>
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
							<div class="col-md-3">
								<ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="pills-aktif-tab" data-toggle="pill" href="#pills-aktif" role="tab" aria-controls="pills-aktif" aria-selected="true">Booth Aktif</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="pills-na-tab" data-toggle="pill" href="#pills-na" role="tab" aria-controls="pills-na" aria-selected="false">Booth Non-Aktif</a>
									</li>
								</ul>
							</div>
							<div class="col-md-9 mt-1">
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
						<div class="separator-solid mb-4"></div>
						<div class="tab-content mt-2 mb-3" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-aktif" role="tabpanel" aria-labelledby="pills-aktif-tab">
								<div class="row" id="list">
									@foreach ($booths as $booth)
									<div class="col-md-4 target ">
										<div class="card card-post card-round full-height" style="border: 1px #cccccc solid; {{$booth->status == 0 ? 'background-color: #f2f2f2' : null }}">
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
													<div class="col-md-12">	
														<h6><b>Alamat Booth : </b></h6>
														<p>{{$booth->alamat_booth}}, {{$booth->kota_booth}}</p>
														<h6><b>Jam Operasional : </b></h6>
														<p>{{date('H:i',strtotime($booth->jam_buka))}} - {{date('H:i',strtotime($booth->jam_tutup))}} WIB</p>
													</div>
													<div class="col-md-12">
														<h6><b>Pegawai : </b></h6>
														@php
															$i = 1;
														@endphp
														@foreach ($kasirs as $kasir)
														@if ($kasir->id_booth == $booth->id_booth)
															<p class="nama_kasir">{{$i++.'.'.' '.$kasir->nama_kasir}}</p>
														@endif
														@endforeach
													</div>
												</div>
											</div>
											<div class="card-footer">
												<div class="text-center">
													<a href="{{ route('admin.detail-booth', $booth->id_booth) }}" class="btn btn-primary btn-rounded btn-sm">Detail Booth</a>
												</div>
											</div>
											
										</div>
									</div>
									@endforeach
								</div>
							</div>
							<div class="tab-pane fade show" id="pills-na" role="tabpanel" aria-labelledby="pills-na-tab">
								@if (count($nb)<1)
									<div class="text-center">
										<h3>Tidak Ada Data</h3>
									</div>
								@endif
								<div class="row" id="list">
									@foreach ($nb as $booth)
									<div class="col-md-4 target ">
										<div class="card card-post card-round full-height" style="border: 1px #cccccc solid; {{$booth->status == 0 ? 'background-color: #f2f2f2' : null }}">
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
													<div class="col-md-12">	
														<h6><b>Alamat Booth : </b></h6>
														<p>{{$booth->alamat_booth}}, {{$booth->kota_booth}}</p>
														<h6><b>Jam Operasional : </b></h6>
														<p>{{date('H:i',strtotime($booth->jam_buka))}} - {{date('H:i',strtotime($booth->jam_tutup))}} WIB</p>
													</div>
													<div class="col-md-12">
														<h6><b>Pegawai : </b></h6>
														@php
															$i = 1;
														@endphp
														@foreach ($kasirs as $kasir)
														@if ($kasir->id_booth == $booth->id_booth)
															<p class="nama_kasir">{{$i++.'.'.' '.$kasir->nama_kasir}}</p>
														@endif
														@endforeach
													</div>
												</div>
											</div>
											<div class="card-footer">
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
		</div>
	</div>
@endsection
@section('js')
	<script>
		function Search() {
		  var input = document.getElementById("search");
		  var filter = input.value.toLowerCase();
		  var nodes = document.getElementsByClassName('target');
		  var list = document.getElementById('list');

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
