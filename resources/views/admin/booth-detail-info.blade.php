@extends('admin/booth-detail')
@section('css')
	<style>
		.table th, .table td{
			height: 2.5rem !important;
			border: 1px solid grey !important;
		}
	</style>
@endsection
@section('content2')	

	<div class="card border shadow-none">
		<div class="card-body">
			<h4><b><span class="fas fa-clipboard-list text-warning"></span>&nbsp; INFO</b></h4>
			<div class="separator-solid"></div>
			<div class="row">
				<div class="col-md-12">
					<ul class="nav nav-pills nav-secondary nav-pills-no-bd text-right" id="pills-tab-without-border" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="pills-bulan-tab-nobd" data-toggle="pill" href="#pills-bulan-nobd" role="tab" aria-controls="pills-bulan-nobd" aria-selected="true">Bulan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="pills-hari-tab-nobd" data-toggle="pill" href="#pills-hari-nobd" role="tab" aria-controls="pills-hari-nobd" aria-selected="false">Hari</a>
						</li>
					</ul>
					<div class="tab-content mt-4 mb-3" id="pills-without-border-tabContent">
						<div class="tab-pane fade show active" id="pills-bulan-nobd" role="tabpanel" aria-labelledby="pills-bulan-tab-nobd">
							<div class="chart-container">
								<canvas id="IncomeBulan"></canvas>
							</div>
						</div>
						<div class="tab-pane fade show" id="pills-hari-nobd" role="tabpanel" aria-labelledby="pills-hari-tab-nobd">
							<div class="chart-container">
								<canvas id="IncomeHarian"></canvas>
							</div>
						</div>
					</div>
					<div class="separator-solid"></div>
				</div>
				
				<div class="col-md-3 mt-2">
					<form action="" method="GET">
						<select name="bulan" class="form-control" onchange="if(this.value != 0) { this.form.submit(); }" style="border-color: grey">
							@php
								$i=1;
							@endphp
							@foreach (NamaBulan() as $n => $nama)
								<option value="{{$n}}" {{$b == $n ? 'selected':null}}>{{$nama.', '.date('Y')}} </option>
							@endforeach
						</select>
					</form>
				</div>
				@if(count($tb) != null && count($pj) != null)
				<div class="col-md-12">
					<h4 ><b> </b></h4>
					<table class="table">
						<tr>
							<th colspan="4" style="text-transform: uppercase; border: none !important; text-align: center; padding-bottom: 1rem !important;">data BULAN {{BulanIndo($b).' '.date('Y')}}</th>
						</tr>
						<tr>
							<th colspan="4">TRANSAKSI</th>
						</tr>
						
						<tr class="thead-light">
							<th></th>
							<th>Transaksi</th>
							<th>Pajak</th>
							<th>Total Bersih</th>
						</tr>
						@php
							$t = 0; $p = 0; $b = 0;
						@endphp
						@foreach ($tb as $tb)
						<tr>
							<th style="background-color: #e9ecef">{{$tb->jenis}}</th>
							<td>{{$tb->trans}}</td>
							<td>Rp {{Rupiah($tb->t_pajak)}}</td>
							<td>Rp {{Rupiah($tb->total_b)}}</td>
						</tr>
						@php
							$t += $tb->trans;
							$p += $tb->t_pajak;
							$b += $tb->total_b;
						@endphp
						@endforeach
						<tr style="background-color: #e9ecef">
							<th>Total</th>
							<th>{{$t}}</th>
							<th>Rp {{Rupiah($p)}}</th>
							<th>Rp {{Rupiah($b)}}</th>
						</tr>
						<tr>
							<th colspan="4">PRODUK TERJUAL</th>
						</tr>
						<tr style="background-color: #e9ecef">
							
							<th>Nama Produk</th>
							<th>Jumlah</th>
							<th rowspan="{{count($pj)+1}}" colspan="2"></th>
						</tr>
						@foreach ($pj as $pj)
							<tr>
								<td>{{$pj->nama_makanan}}</td>
								<td>{{$pj->jumlah}} Porsi</td>
							</tr>
						@endforeach
					</table>
				</div>
				@else
				<div class="col-md-12 text-center mt-4 mb-4">
					<h4 class="border pt-4 pb-4">Belum Ada Transaksi</h4>
				</div>
				@endif
			</div>
		</div>
	</div>

@endsection
@section('js')
	<script src="{{ asset('assets/atlantis/js/plugin/chart-js/chart.min.js') }} "></script>
	<script>
		var IncomeBulan = document.getElementById('IncomeBulan').getContext('2d');

		var myIncomeBulan = new Chart(IncomeBulan, {
			type: 'bar',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
				datasets : [
					{
						label: "Income",
						pointBorderColor: "#FFF",
						pointBackphpgroundColor: "#20b218",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						fill: true,
						borderWidth: 2,
						backgroundColor: 'orange',
						borderColor: '#b5b5b5',
						data: [{{implode(',',$income)}}],
					},
					{
						label: "Pajak",
						pointBorderColor: "#FFF",
						pointBackphpgroundColor: "#20b218",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						fill: true,
						borderWidth: 2,
						backgroundColor: 'red',
						borderColor: '#b5b5b5',
						data: [{{implode(',',$pjk)}}],
					}
				]
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					display: top,
				},
				tooltips: {
	                enabled: true,
	                mode: 'single',
	                callbacks: {
	                    label: function(tooltipItems, data) { 
	                    	if (tooltipItems.datasetIndex == 0) {
	                        	return 'Income : Rp '+ tooltipItems.yLabel + ' K';
	                        }
	                        else if (tooltipItems.datasetIndex == 1) {
	                        	return 'Pajak : Rp '+ tooltipItems.yLabel + ' K';
	                        }
	                    }
	                }
	            },
				scales: {
					yAxes: [{
						ticks: {
		                    callback: function(label, index, labels) {
		                        return label+' K';
		                    }
		                }	
					}]
				}
				
			}
		});

	</script>
	<script>
		var IncomeHarian = document.getElementById('IncomeHarian').getContext('2d');

		var myIncomeHarian = new Chart(IncomeHarian, {
			type: 'bar',
			data: {
				labels: {!!json_encode(array_reverse($lb))!!},
				datasets : [
					{
						label: "Income",
						pointBorderColor: "#FFF",
						pointBackphpgroundColor: "#20b218",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						fill: true,
						borderWidth: 2,
						backgroundColor: 'orange',
						borderColor: '#b5b5b5',
						data: [{{implode(',', array_reverse($th))}}],
					},
					{
						label: "Pajak",
						pointBorderColor: "#FFF",
						pointBackphpgroundColor: "#20b218",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						fill: true,
						borderWidth: 2,
						backgroundColor: 'red',
						borderColor: '#b5b5b5',
						data: [{{implode(',',array_reverse($tax_h))}}],
					}
				],
			},
			options: {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					display: top,
				},
				tooltips: {
	                enabled: true,
	                mode: 'single',
	                callbacks: {
	                    label: function(tooltipItems, data) { 
	                    	if (tooltipItems.datasetIndex == 0) {
	                        	return 'Income : Rp '+ tooltipItems.yLabel + ' K';
	                        }
	                        else if (tooltipItems.datasetIndex == 1) {
	                        	return 'Pajak : Rp '+ tooltipItems.yLabel + ' K';
	                        }
	                    }
	                }
	            },
				scales: {
					yAxes: [{
						ticks: {
		                    callback: function(label, index, labels) {
		                        return label+' K';
		                    }
		                }	
					}]
				}
				
			}
		});

	</script>
@endsection