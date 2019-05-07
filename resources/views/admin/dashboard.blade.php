@extends('admin/master-d')
@section('content')
	<div class="panel-header bg-warning-gradient">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="text-white pb-2 fw-bold">Dashboard</h2>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div class="page-inner mt--5">
		<div class="row mt--2">
			<div class="col-md-6">
				<div class="card full-height">
					<div class="card-body">
						<div class="card-title">Jumlah Transaksi Bulan {{BulanIndo(date('n')).' '.date('Y')}}</div>
						<div class="card-category">Data Seluruh Booth Pawon Lijo</div>
						<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
							@foreach ($tb as $j)
								<div class="px-2 pb-2 pb-md-0 text-center">
									<div id="circles-{{$j->jenis}}"></div>
									<h6 class="fw-bold mt-3 mb-0">{{$j->jenis}}</h6>
								</div>
							@endforeach
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card full-height">
					<div class="card-body">
						<div class="card-title">Total Pendapatan & Pajak Bulan {{BulanIndo(date('n')).' '.date('Y')}}</div>
						<div class="card-category">Data Seluruh Booth Pawon Lijo</div>
						<div class="row py-3">
							<div class="col-md-4 d-flex flex-column justify-content-around">
								<div>
									<h6 class="fw-bold text-uppercase text-success op-8">Total Bersih</h6>
									<h3 class="fw-bold">Rp {{Rupiah($bulan)}} K</h3>
								</div>
								<div>
									<h6 class="fw-bold text-uppercase text-danger op-8">Total Pajak</h6>
									<h3 class="fw-bold">Rp {{Rupiah($pajak) }} K</h3>
								</div>
							</div>
							<div class="col-md-8">
								<div id="chart-container">
									<canvas id="totalIncomeChart"></canvas>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card border">
					<div class="card-header">
						<div>
							<h4 class="card-title">Pendapatan Harian Booth Pawon Lijo</h4>
						</div>
					</div>
					<div class="card-body">
						<div id="chart-container" style="height:50vh;">
							<canvas id="totalIncomeHarian"></canvas>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="card border full-height">
					<div class="card-body">
						<h4>
							<i class="fas fa-tags text-warning mr-2"></i>Produk Terlaris Bulan {{BulanIndo(date('n')).' '.date('Y')}}
						</h4>
						<div class="separator-solid"></div>
						@foreach ($top as $top)
						<div class="d-flex">
							<div class="flex-1 pt-1">
								<h5 class="fw-bold mb-1">{{$top->nama_makanan}}</h5>
							</div>
							<div class="d-flex ml-auto align-items-center">
								<h3 class="text-info fw-bold">{{$top->jumlah}} Porsi</h3>
							</div>
						</div>
						<div class="separator-dashed"></div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card border full-height">
					<div class="card-body">
						<h4>
							<i class="fas fa-store text-warning mr-2"></i>Jumlah Transaksi Bulan {{BulanIndo(date('n')).' '.date('Y')}}
						</h4>
						<div class="separator-solid"></div>
						@foreach ($jt as $jt)
							
							
							<div class="d-flex">
								<div class="flex-1 pt-1">
									@foreach ($booths as $boo)
										@if ($jt->id_booth == $boo->id_booth)
											<h5 class="fw-bold mb-1">{{$boo->nama_booth}}, {{$boo->kota_booth}}</h5>
										@endif
									@endforeach
								</div>
								<div class="d-flex ml-auto align-items-center">
									<h3 class="text-success fw-bold">{{$jt->jid}} Transaksi</h3>
								</div>
							</div>

							<div class="separator-dashed"></div>
							
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card full-height border">
					<div class="card-body">
						<h4>
							<i class="fas fa-handshake text-warning mr-2"></i>Transaksi Terbaru
						</h4>
						<div class="separator-solid"></div>
						<ol class="activity-feed">
							@foreach ($nt as $nt)
								<li class="feed-item feed-item-default">
									<time class="date">
										{{date('j/n/Y H:i', strtotime($nt->created_at))}}
										@if ($nt->status == 1)
										 	<button class="btn btn-xs btn-success pt-0 pb-0 ml-2"> Sukses </button>
										@elseif($nt->status == 2)
											<button class="btn btn-xs btn-warning pt-0 pb-0 ml-2"> Pending </button>
										@else
											<button class="btn btn-xs btn-danger pt-0 pb-0 ml-2"> Batal </button>
										@endif 
										
									</time>
									<span class="text">{{$nt->id_booth}} - {{$nt->jenis}} - <a href="{{ route('admin.sales-detail',$nt->id) }}">{{$nt->id}}</a></span>
								</li>
							@endforeach
						</ol>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{ asset('assets/atlantis/js/plugin/chart-js/chart.min.js') }}"></script>

	<!-- jQuery Sparkline -->
	<script src="{{ asset('assets/atlantis/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- Chart Circle -->
	<script src="{{ asset('assets/atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>
	<script>
		@php
			$a = 1;
			$b = count($tb);
			$colors = [ 1 => '#F25961','#2BB930','#FF9E27','#609dff'];
		@endphp
		@foreach ($jenis as $e)
			@foreach ($tb as $t)
				@if ($e->jenis_transaksi == $t->jenis)
				Circles.create({
					id:'circles-{{$t->jenis}}',
					radius:45,
					value:{{$t->jumlah}},
					maxValue:30,
					width:10,
					text: {{$t->jumlah}},
					colors:['#f1f1f1', '{{$colors[$b--]}}' ],
					duration:400,
					wrpClass:'circles-wrp',
					textClass:'circles-text',
					styleWrapper:true,
					styleText:true
				})
				@endif
			@endforeach

		@endforeach
	
		
		var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');
		var mytotalIncomeChart = new Chart(totalIncomeChart, {
			type: 'bar',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
				datasets : [{
					label: "Total Income",
					backgroundColor: '#ff9e27',
					borderColor: 'rgb(23, 125, 255)',
					data: [{{implode(',',$income)}}],
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				tooltips: {
	                enabled: true,
	                mode: 'single',
	                callbacks: {
 						label: function(tooltipItems, data) { 
								return 'Income : Rp '+ tooltipItems.yLabel + ' K';
						}
					}
				},
				scales: {
					yAxes: [{
						ticks: {
							display: false //this will remove only the label
						},
						gridLines : {
							drawBorder: false,
							display : false
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

		var totalIncomeHarian = document.getElementById('totalIncomeHarian').getContext('2d');

		var mytotalIncomeHarian = new Chart(totalIncomeHarian, {
			type: 'line',
			data: {
				labels: {!!json_encode(array_reverse($lh))!!},
				datasets: [
				@php
					$a = 0;
					$s = 0;
					$c = 0;
					$color = ['red','blue','green','yellow','grey','orange','pink']
				@endphp
				@foreach ($booths as $b)
					{
						label: "{{$b->nama_booth}}",
						borderColor: "{{$color[$c++]}}",
						pointBorderColor: "#FFF",
						pointBackgroundColor: "{{$color[$s++]}}",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						backgroundColor: 'transparent',
						fill: true,
						borderWidth: 2,
						data: [{{implode(',',array_reverse($hari[$a++]))}}]
					},
				@endforeach
				]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'right',
					labels : {
						padding: 20,
						fontColor: 'black',
						fontSize: 12
					}
				},
				tooltips: {
					mode: 'index',
					intersect: false,
					callbacks: {
	                    label: function(tooltipItems, data) { 
	                        return 'Income : Rp '+ tooltipItems.yLabel + ' K';
	                    }
	                }
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
			        yAxes: [{
			            beginAtZero:true,
		                ticks: {
		                    callback: function(label, index, labels) {
		                        return label+' K';
		                    }
		                }
			        }]
			    }
			}
		});

		$('#lineChart').sparkline([105,103,123,100,95,105,115], {
			type: 'line',
			height: '70',
			width: '100%',
			lineWidth: '2',
			lineColor: '#ffa534',
			fillColor: 'rgba(255, 165, 52, .14)'
		});
	</script>
@endsection