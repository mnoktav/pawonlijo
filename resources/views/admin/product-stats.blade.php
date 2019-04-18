@extends('admin/product')
@section('css')
	<style>
		.filter .card{
			border: 1px solid #cccccc;
			background-color: #f4f4f4;
		}
		.filter label{
			font-weight: normal;
			margin-bottom: 0.2rem;
		}
		.filter .form-group{
			padding: 0;
			margin-bottom: 0.5rem;
		}
		.filter select{
			border: 1px solid #dddddd;
		}
		.table-6 td{
			padding: 0.5rem 2rem;
			border: 1px solid #dddddd
		}
	</style>
@endsection
@section('booth-product')	
	<div class="row">
		<div class="col-md-3 filter">
			<div class="card shadow-none">
				<div class="card-body">
				    <div class="filter">
				    	<h4><b><i class="fas fa-search mr-2 text-primary"></i>Filter</b></h4>
					    <div class="dropdown-divider" style="border: 1px solid #cccccc"></div>
					    <div class="form-filter">
					    	<form action="" method="get">
						    	<div class="form-group">
									<label for="nama-booth" class="col-form-label">Booth : </label>
									<select class="form-control" name="id_booth">
										<option value="">Semua</option>
										@foreach ($booths as $b)
											<option value="{{$b->id_booth}}" {{$id_booth == $b->id_booth ? 'selected' : null}}>{{$b->nama_booth}}, {{$b->kota_booth}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label for="waktu" class="col-form-label">Waktu : </label>
									<select class="form-control" name="waktu" id="waktu">
										<option value="hari">Hari ini</option>
										<option value="minggu" {{$waktu == 'minggu' ? 'selected' : null}}>Minggu ini</option>
										<option value="bulan" {{$waktu == 'bulan' ? 'selected' : null}}>Bulan ini</option>
									</select>
								</div>
							
								<div class="text-center mt-3">
									<input type="submit" value="Filter" class="btn btn-primary btn-sm btn-rounded pr-4 pl-4">
								</div>
							</form>
					    </div>
				    </div>
				</div>
			</div>
		</div>
		<div class="col-md-9">	
			<div class="card shadow-none" style="border: 1px solid #dddddd; ">
				<div class="card-body">
					<div class="text-center mb-3">
						<h4><b>PRODUK PALING DIMINATI</b></h4>
					</div>

					<div class="chart-container mb-4">
						<canvas id="ProdukTransaksiMinggu"></canvas>
					</div>
					@if(count($jl) != null)
					<div class="table-responsive">
						<table class="table table-striped">
							<tr class="bg-warning text-light">
								<th>No.</th>
								<th>Nama Makanan</th>
								<th>Porsi</th>
							</tr>
							@php
								$i = 6;
							@endphp
							@foreach ($jl as $j)
							<tr>
								<td>{{$i++}}</td>
								<td>{{$j->nama_makanan}}</td>
								<td>{{$j->jumlah}}</td>
							</tr>
							@endforeach
						</table>
					</div>	
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script src="{{ asset('assets/atlantis/js/plugin/chart-js/chart.min.js') }} "></script>

	<script>
		var ProdukTransaksiMinggu = document.getElementById('ProdukTransaksiMinggu').getContext('2d');

		var myProdukTransaksiMinggu = new Chart(ProdukTransaksiMinggu, {
			type: 'bar',
			data: {
				labels: {!!json_encode($label)!!},
				datasets : [{
					label: "Porsi",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: {{StringToInt($jh)}},
				}],
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});

	</script>
@endsection
