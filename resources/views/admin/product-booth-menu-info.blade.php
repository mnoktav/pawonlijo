@extends('admin/master-d')
@section('css')
	<style>
	.list {
		border: 1px solid #dddddd;
	}
	.list h5{
		text-transform: uppercase;
		margin-bottom: 0;
	}
	.harga th, .harga td{
		padding: 0.3rem 0.4rem;
		font-size: 0.75rem;
		border-radius: 1rem;
	}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Daftar Menu PawonLijo</h4>
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
					<a>Daftar Menu</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$booth->nama_booth}}</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$menu->nama_makanan}}</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>NAMA MAKANAN</b></h4>
								<small style="text-transform: uppercase;">{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.product-booth-menu',$booth->id_booth) }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="card" style="border: 1px solid #dddddd;">
							<div class="card-body">
								<h4><b>INFORMASI MAKANAN</b></h4>
								<div class="separator-solid"></div>
								<div class="row">
									<div class="col-md-4">
										<div class="image">
											@if ($menu->gambar != null)
												<img src="{!! asset($menu->gambar) !!}" class="w-100" alt="">
											@else
												<img src="{{ asset('assets/img/nf.png') }}" class="w-100" alt="">
											@endif
											
										</div>
									</div>
									<div class="col-md-8">
										<div class="table">
											<table class="table table-striped">
												<tr>
													<th width="15%">Nama</th>
													<td width="1%">:</td>
													<td>{{$menu->nama_makanan}}</td>
												</tr>
												<tr>
													<th>Kategori</th>
													<td>:</td>
													<td style="text-transform: capitalize;">{{$menu->kategori}}</td>
												</tr>
												<tr>
													<th>Reguler</th>
													<td>:</td>
													<td>Rp {{Rupiahd($menu->harga_reguler)}}</td>
												</tr>
												<tr>
													<th>Go-Food</th>
													<td>:</td>
													<td>Rp {{Rupiahd($menu->harga_gojek)}}</td>
												</tr>
												<tr>
													<th>Grab</th>
													<td>:</td>
													<td>Rp {{Rupiahd($menu->harga_grab)}}</td>
												</tr>
												<tr>
													<th>Booth</th>
													<td>:</td>
													<td>{{$booth->nama_booth.', '.$booth->kota_booth}}</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card" style="border: 1px solid #dddddd;">
							<div class="card-body">
								<h4><b>INFORMASI PENJUALAN PRODUK</b></h4>
								<div class="separator-solid"></div>
								<div class="row">
									<div class="col-md-12">
										<ul class="nav nav-pills nav-primary pull-right mt--2" id="pills-tab" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="pills-hari-tab" data-toggle="pill" href="#pills-hari" role="tab" aria-controls="pills-hari" aria-selected="true">Hari</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="pills-bulan-tab" data-toggle="pill" href="#pills-bulan" role="tab" aria-controls="pills-bulan" aria-selected="false">Bulan</a>
											</li>
										</ul>
									</div>
									<div class="col-md-12">
										<div class="tab-content mt-2 mb-3" id="pills-tabContent">
											<div class="tab-pane fade show active" id="pills-hari" role="tabpanel" aria-labelledby="pills-hari-tab">
												<div class="chart-container">
													<canvas id="lineChart1"></canvas>
												</div>
											</div>
											<div class="tab-pane fade" id="pills-bulan" role="tabpanel" aria-labelledby="pills-bulan-tab">
												<div class="chart-container">
													<canvas id="lineChart2"></canvas>
												</div>
											</div>
										</div>
									</div>
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
	<script src="{{ asset('assets/atlantis/js/plugin/chart-js/chart.min.js') }} "></script>
	<script>
		var lineChart1 = document.getElementById('lineChart1').getContext('2d');
		var lineChart2 = document.getElementById('lineChart2').getContext('2d');
		var myLineChart1 = new Chart(lineChart1, {
			type: 'line',
			data: {
				labels: {!!json_encode(array_reverse($pl))!!},
				datasets: [{
					label: "{{$menu->nama_makanan}}",
					borderColor: "#1d7af3",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#1d7af3",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [{{implode(',', array_reverse($ph))}}]
				}]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode:"nearest",
					intersect: 0,
					position:"nearest",
					xPadding:10,
					yPadding:10,
					caretPadding:10
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						},
						scaleLabel: {
							display: true,
							labelString: 'Porsi'
						}
					}]
				}
			}
		});
		var myLineChart2 = new Chart(lineChart2, {
			type: 'line',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"],
				datasets: [{
					label: "{{$menu->nama_makanan}}",
					borderColor: "#1d7af3",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#1d7af3",
					pointBorderWidth: 2,
					pointHoverRadius: 4,
					pointHoverBorderWidth: 1,
					pointRadius: 4,
					backgroundColor: 'transparent',
					fill: true,
					borderWidth: 2,
					data: [{{implode(',', $pb)}}]
				}]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
					bodySpacing: 4,
					mode:"nearest",
					intersect: 0,
					position:"nearest",
					xPadding:10,
					yPadding:10,
					caretPadding:10
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						},
						scaleLabel: {
							display: true,
							labelString: 'Porsi'
						}
					}]
				}
			}
		});
	</script>
@endsection
