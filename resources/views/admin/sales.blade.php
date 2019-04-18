@extends('admin/master-d')
@section('css')
	<style>
		.table th, .table td{
			font-size: 0.8rem;
		}
		.info td{
			padding: 5px;
		}
		input[readonly]{
			background-color: white;
		}
		p{
			margin: 0;
		}
		.popover{
			width:30%;
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
								<div class="card border">
									<div class="card-body">
										<div class="row">
											<div class="col-md-10">
												<h5><h4 clas><i class="fas fa-info-circle mr-2 text-primary"></i><b>PENJUALAN TAHUN 2019</b></h4></h5>
											</div>
											<div class="col-md-2">
												<form action="" method="get">
													<select name="chart" class="form-control border" onchange="this.form.submit();">
														<option value="t" {{$rc == 't' ? 'selected':null}}>Transaksi</option>
														<option value="p" {{$rc == 'p' ? 'selected':null}}>Income</option>
													</select>
												</form>
											</div>
										</div>
										
										<div class="separator-solid mt-4"></div>
										<div class="chart-container">
											<canvas id="ProdukTransaksiTahun"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="separator-solid"></div>
						{{-- @php
							dd($jenis);
						@endphp --}}
						<div class="row">
							
							@if (is_null($t_awal))
								<div class="col-md-6" style="text-transform: uppercase; padding-left: 2.5%">
									<small><b>Daftar Penjualan Semua Booth PawonLijo</b></small><br>
									<small><b>sampai dengan : {{date('d/m/Y H:i')}}</b></small>
								</div>
							@else
								<div class="col-md-6" style="text-transform: uppercase; padding-left: 2.5%">
									@if($id_booth == '')
										<small><b>Daftar Penjualan Semua Booth PawonLijo</b></small><br>
									@else
										<small><b>Daftar Penjualan Booth {{$id_booth}}</b></small><br>
									@endif
									<small><b>Tanggal :  {{date('d/m/Y', strtotime($t_awal))}}</b></small>
									@if($t_akhir != '')
										<small><b> - {{date('d/m/Y', strtotime($t_akhir))}}</b></small>
									@endif
									<br>
									<small><b>
										Jenis : {{implode(', ',$jenis)}}
										
									</b></small>
								</div>
							@endif
							<div class="col-md-6 mb-2 text-right" style="padding-right: 2.5%">
								<button data-toggle="modal" data-target="#FilterModal" class="btn btn-sm"><i class="fas fa-search"></i></button>
								<button href="#popover_content_wrapper" class="btn btn-sm btn-pop" data-trigger="focus"><i class="fas fa-info"></i></button>
							</div>
							

							<div id="popover_content_wrapper" style="display: none">
								<div class="head" style="border-bottom: 1px solid #aaaaaa;">
									<h4><i class="fas fa-info-circle mr-2"></i>INFO</h4>
								</div>
								<table class="table table-striped mt-2 text-center border">
									<tr>
										<td></td>
										<td>Transaksi</td>
										<td>Pendapatan</td>
									</tr>
									@php
										$tt = 0;
										$tp = 0;
									@endphp
									@foreach ($jumlah_t as $t)
										<tr>
											<td>{{$t->jenis}}</td>
											<td>{{$t->jumlah}}</td>
											<td>Rp {{$t->total}}</td>
										</tr>
										@php
											$tt += $t->jumlah;
											$tp += $t->total;
										@endphp
									@endforeach
									<tr>
										<td><b>TOTAL</b></td>
										<td>{{$tt}}</td>
										<td>Rp {{$tp}}</td>
									</tr>
								</table>
							</div>

							<div class="col-md-12">
								<div class="table-responsive mt-2">
									<table class="table table-striped transaksi">
										<thead class="bg-dark text-light">
											<tr>
												<th>TANGGAL</th>
												<th>ID TRANSAKSI</th>
												<th>JENIS TRANSAKSI</th>
												<th>KODE</th>
												<th>TOTAL</th>
												<th>POTONGAN</th>
												<th>TOTAL BAYAR</th>
												<th>Detail</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($sales as $sale)
											<tr>
												<td>{{date('d/m/Y H:i',strtotime($sale->created_at))}}</td>
												<td>{{$sale->id}}</td>
												<td>{{$sale->jenis}}</td>
												@if($sale->kode != null)
												<td>{{$sale->kode}}</td>
												@else
												<td>-</td>
												@endif
												<td>Rp {{$sale->subtotal}}</td>
												<td>Rp {{$sale->potongan}}</td>
												<td>Rp {{$sale->total}}</td>
												<td><a href="{{ route('admin.sales-detail',$sale->id) }}" class="btn btn-primary btn-sm">Detail</a></td>
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
		</div>
	</div>
	<div class="modal fade" id="FilterModal">
    	<div class="modal-dialog">
    		<div class="modal-content">
    			<div class="modal-header">
    				<h4><i class="fa fa-search mr-2 text-primary"></i><b>Filter</b></h4>
    			</div>
				<form action="" method="GET">
				<div class="modal-body">
					<div class="row pl-2 pr-2">
						<div class="col-md-6">
							<div class="form-group p-0">
								<label>BOOTH</label>
								<select class="form-control" name="id_booth" id="nama-booth">
									<option value="">Semua</option>
									@foreach ($booths as $booth)
										<option value="{{$booth->id_booth}}" {{$id_booth == $booth->id_booth ? 'selected' : null}}>{{$booth->nama_booth}}, {{$booth->kota_booth}}</option>
									@endforeach
									
								</select>
							</div>
							<div class="form-group p-0 mt-3">
								<label class="">TANGGAL AWAL</label>
								<input type="date" class="form-control" name="t_awal" value="{{$t_awal}}" required="">
							</div>
							<div class="form-group p-0 mt-3">
								<label class="">TANGGAL AKHIR</label>
								<input type="date" class="form-control" name="t_akhir" value="{{$t_akhir}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group p-0">
								<label>JENIS TRANSAKSI</label>
								<div class="input-group mb-1">
								  	<div class="input-group-prepend">
								    	<div class="input-group-text">
								      		<input type="checkbox" aria-label="Radio button for following text input" name="jenis[]" value="reguler" {{GetSelected($jenis,'reguler') == true ? 'checked' : null}}>
								    	</div>
								  	</div>
								  	<input type="text" class="form-control" value="Reguler" readonly style="background-color: white !important; color: black !important">
								</div>
								<div class="input-group mb-1">
								  	<div class="input-group-prepend">
								    	<div class="input-group-text">
								      		<input type="checkbox" aria-label="Radio button for following text input" name="jenis[]" value="gojek" {{GetSelected($jenis,'gojek') == true ? 'checked' : null}}>
								    	</div>
								  	</div>
								  	<input type="text" class="form-control" value="Gojek" readonly style="background-color: white !important; color: black !important">
								</div>
								<div class="input-group">
								  	<div class="input-group-prepend">
								    	<div class="input-group-text">
								      		<input type="checkbox" aria-label="Radio button for following text input" name="jenis[]" value="grab" {{GetSelected($jenis,'grab') == true ? 'checked' : null}}>
								    	</div>
								  	</div>
								  	<input type="text" class="form-control" value="Grab" readonly style="background-color: white !important; color: black !important">
								</div>
								<div class="input-group">
								  	<div class="input-group-prepend">
								    	<div class="input-group-text">
								      		<input type="checkbox" aria-label="Radio button for following text input" name="jenis[]" value="pesanan" {{GetSelected($jenis,'pesanan') == true ? 'checked' : null}}>
								    	</div>
								  	</div>
								  	<input type="text" class="form-control" value="Pesanan" readonly style="background-color: white !important; color: black !important">
								</div>
								<small class="alertbox">Pilih minimal satu.</small>
							</div>
						</div>
						<p style="display: none;" class="text-danger pl-3 pr-3 mt-2">*Untuk mencari data perhari isi tanggal awal dan kosongkan tanggal akhir</p>
					</div>
				</div>
				<div class="modal-footer">
					<div class="text-right">
						<a href="{{ route('admin.sales') }}" class="btn btn-danger btn-sm btn-rounded pl-5 pr-5">Reset</a>
						<input type="submit" value="Filter" name="filter" id="FilterBtn" class="btn btn-primary btn-sm btn-rounded pl-5 pr-5">
					</div>
				</div>
				</form>
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
				datasets : [{
					@if ($rc == 'p')
					label: "Rp",
					@else
					label: "Transaksi",
					@endif
					
					backgroundColor: 'transparent',
					borderColor: 'rgb(23, 125, 255)',
					data: [{{implode(',',$chart)}}],
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
	<script>
		$(document).ready(function() {
			$('.transaksi').DataTable({
				 aaSorting: [[0, 'desc']],
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
