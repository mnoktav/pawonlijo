@extends('admin/master-d')
@section('css')
	<style>
		#table th, #table td{
			font-size: 0.8rem;
			padding: 0.5rem !important;
			height: 2.5rem;
		}
		.info td, .info th{
			height: 3rem;
		}
		input[readonly]{
			background-color: white;
		}
		p{
			margin: 0;
		}
		.popover{
			width:40%;
			height:60%;
			max-width:none;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Data Penjualan PawonLijo</h4>
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
					<a>Data Penjualan</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<div class="card border shadow-none">
									<div class="card-body" style="background-color: #f7f7f7;">
										<div class="row">
											<div class="col-md-10">
												<h5><h4 clas><i class="fas fa-info-circle mr-2 text-primary"></i><b>PENJUALAN TAHUN 2019</b></h4></h5>
											</div>

										</div>
										
										<div class="chart-container mt-4" style="height:60vh;">
											<canvas id="ProdukTransaksiTahun"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card border shadow-none" id="data-transaksi">
							<div class="card-body">
								<div class="row">
									<div class="col-md-12">
										<form action="/admin/sales#data-transaksi" method="GET">
										<div class="row">
											<div class="col-md-3">
												<select name="id_booth" class="form-control" style="border-color: grey">
													<option value="">Semua</option>
													@foreach ($booths as $booth )
														<option value="{{$booth->id_booth}}" {{$id_booth == $booth->id_booth ? 'selected' : null}}>{{$booth->nama_booth}}, {{$booth->kota_booth}} </option>
													@endforeach
												</select>
											</div>
											<div class="col-md-2 ">
												<select name="bulan" class="form-control" style="border-color: grey">
													@php
														$i=1;
													@endphp
													@foreach (NamaBulan() as $n => $nama)
														<option value="{{$n}}" {{$b == $n ? 'selected':null}}>{{$nama}} </option>
													@endforeach
												</select>
											</div>
											<div class="col-md-2">
												<select name="tahun" class="form-control" style="border-color: grey">
													@for ($a=2016; $a < 2027; $a++)
														<option value="{{$a}}" {{$t == $a ? 'selected':null}}>{{$a}}</option>
													@endfor
												</select>
											</div>
											<div class="col-md-1">
												<input type="submit" name="filter" value="Submit" class="btn btn-sm btn-primary mt-1">
											</div>
										</div>
										</form>
										<div class="separator-solid mt-4"></div>
									</div>

									@if (count($sales) != null)
									<div class="col-md-12 mb-2">
										<ul class="nav nav-pills nav-primary mb-4" id="pills-tab" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Tabel</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Grafik</a>
											</li>
										</ul>
										
									
										<div class="tab-content mt-2 mb-3" id="pills-tabContent">
											<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
												<div class="row">
													<div class="col-md-12">
														<div class="card full-height shadow-sm">
															<div class="card-body">
																<h4><b>JUMLAH TRANSAKSI</b></h4>
																<div class="separator-solid"></div>
																<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
																	@foreach ($jumlah_t as $j)
																		<div class="px-2 pb-2 pb-md-0 text-center">
																			<div id="circles-{{$j->jenis}}"></div>
																			<h4 class="fw-bold mt-3" style="text-transform: uppercase;">{{$j->jenis}}</h4>
																			<h6 class="fw-bold text-muted">PENDAPATAN : Rp {{$j->total/1000}} K <br> PAJAK : Rp {{$j->t_pajak/1000}} K</h6>
																		</div>
																	@endforeach
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class="card full-height shadow-sm">
															<div class="card-body">
																<h4><b>PRODUK TERJUAL</b></h4>
																<div class="separator-solid"></div>
																<div class="chart-container mt-4" style="height:60vh;">
																	<canvas id="JumlahProduk"></canvas>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table class="table table-striped transaksi" id="table">
																<thead class="bg-warning text-light">
																	<tr>
																		<th>TANGGAL</th>
																		<th>ID TRANSAKSI</th>
																		<th>JENIS (PAJAK)</th>
																		<th>KODE</th>
																		<th>TOTAL</th>
																		<th>DISCOUNT</th>
																		<th>PAJAK</th>
																		<th>TOTAL BERSIH</th>
																		<th>DETAIL</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach ($sales as $sale)
																	<tr>
																		<td>{{date('d/m/Y H:i',strtotime($sale->created_at))}}</td>
																		<td>{{$sale->id}}</td>
																		<td>
																			{{$sale->jenis}} 
																			({{$sale->pajak}}%)
																		</td>
																		@if($sale->kode != null)
																		<td>{{$sale->kode}}</td>
																		@else
																		<td>-</td>
																		@endif
																		<td>Rp {{Rupiahd($sale->subtotal)}}</td>
																		<td>Rp {{Rupiahd($sale->potongan)}}</td>
																		<td>Rp {{Rupiahd($sale->total_pajak)}}</td>
																		<td>Rp {{Rupiahd($sale->total_bersih)}}</td>
																		<td><a href="{{ route('admin.sales-detail',$sale->id) }}" class="btn btn-primary btn-xs">Detail</a></td>
																	</tr>
																	@endforeach
																</tbody>
															</table>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									@else
									<div class="col-md-12">
										<div class="text-center">
											<h4 class="m-4">Tidak ada data untuk hasil pencarian ini</h4>
										</div>
									</div>
									@endif
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
		var ProdukTransaksiTahun = document.getElementById('ProdukTransaksiTahun').getContext('2d');
		var myProdukTransaksiTahun = new Chart(ProdukTransaksiTahun, {
			type: 'line',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
				datasets : [
					@php
					$a = 0;
					$s = 0;
					$c = 0;
					$d = 0;
					$color = ['red','blue','green','purple','grey','orange','pink']
				@endphp
				@foreach ($booths as $op)
					{
						label: "{{$op->nama_booth}}",
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
						data: [{{implode(',',$ct[$a++])}}]
					},
				@endforeach
				]
			},
			options : {
				responsive: true, 
				maintainAspectRatio: false,
				legend: {
					position: 'bottom',
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
	</script>
	<script>
		var JumlahProduk = document.getElementById('JumlahProduk').getContext('2d');
		var myJumlahProduk = new Chart(JumlahProduk, {
			type: 'bar',
			data: {
				labels : {!!json_encode($top_n)!!},
				@php
					$g = null;
					$u = count($top_n);

					for($v=0; $v < $u; $v++){
					  $g[$v] = '#'.rand(100000,999999); 
					}

				@endphp	
				datasets : [
					{
						label: "Porsi",
						pointBorderWidth: 2,
						pointHoverRadius: 4,
						pointHoverBorderWidth: 1,
						pointRadius: 4,
						backgroundColor: {!!json_encode($g)!!},
						fill: true,
						borderWidth: 2,
						data: [{{implode(',',$top_j)}}]
					},
				]
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
	<script src="{{ asset('assets/atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>
	<script>
		@php
			$a = 1;
			$b = count($jumlah_t);
			$colors = [ 1 => '#F25961','#2BB930','#FF9E27','#609dff'];
		@endphp
		@foreach ($jenis as $e)
			@foreach ($jumlah_t as $t)
				@if ($e->jenis_transaksi == $t->jenis)
				Circles.create({
					id:'circles-{{$t->jenis}}',
					radius:60,
					value:{{$t->jumlah}},
					maxValue:100,
					width:15,
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
	</script>
	<script>	
		$(document).ready(function(){
		  $('.btn-pop').popover({ 
		    html : true,
		    content: function() {
		      return $('#popover_content_wrapper').html();
		    }
		  });
		});
	</script>
	<script src="{{ asset('assets/atlantis/js/plugin/datatables/datatables.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
	<script>
		$(document).ready(function() {
			$.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );
			$('.transaksi').DataTable({
				 aaSorting: [[0, 'desc']],
				 columnDefs: [{
				    target: 0,
				    type: 'datetime-moment'
				  }],
				 "pageLength": 25
			});
		})
	</script>
	<script>
	$(document).ready(function () {
	    $('#FilterBtn').click(function() {
	      checked = $("input[type=checkbox]:checked").length;

	      if(!checked) {
	        return false;
	      }

	    });
	});
	</script>
@endsection
