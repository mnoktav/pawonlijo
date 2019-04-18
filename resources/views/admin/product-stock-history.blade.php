@extends('admin/master-d')
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Stok Menu PawonLijo</h4>
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
					<a>Stok Menu PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Nama Booth</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>STOK PRODUK</b></h4>
								<small>{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.stock-product-booth',$booth->id_booth) }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="text-center"><h3 style="text-transform: uppercase;"><b>
							RIWAYAT STOK <br>
							{{$p->nama_makanan}} - {{$booth->nama_booth}}</b></h3>
						</div>
						<div class="chart-container">
							<canvas id="lineChart1"></canvas>
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
		var myLineChart1 = new Chart(lineChart1, {
			type: 'line',
			data: {
				labels: {!!json_encode(array_reverse($pl))!!},
				datasets: [{
					label: "Sisa Stok",
					borderColor: "#f21c4e",
					pointBorderColor: "#FFF",
					pointBackgroundColor: "#f21c4e",
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
					display: false
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
				layout:{
					padding:{left:15,right:15,top:15,bottom:15}
				}
			}
		});
	</script>
@endsection
