@extends('kasir/master-d')
@section('css')
	<style>
		.table td, .table th{
			padding: 0.5rem !important;
		}
	</style>
@endsection
@section('content')
	<div class="page-inner">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-8">
						<h4 style="text-transform: uppercase;"><b>REPORT HARIAN {{session('login')['nama_booth']}}</b></h4>
					</div>
					<div class="col-md-4 text-right">
						<small class="ml-4">Update terakhir : 20:11 WIB</small>
					</div>
				</div>
				<div class="separator-solid mb-4"></div>
				<div class="row ">
					<div class="col-sm-6 col-md-4">
						<div class="card card-stats card-round border">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-success bubble-shadow-small">
											<i class="flaticon-graph"></i>
										</div>
									</div>
									<div class="col col-stats ml-3 ml-sm-0">
										<div class="numbers">
											<p class="card-category">Pemasukan</p>
											<h4 class="card-title">Rp {{$total/1000}} K</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div class="card card-stats card-round border">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-primary bubble-shadow-small">
											<i class="flaticon-success"></i>
										</div>
									</div>
									<div class="col col-stats ml-3 ml-sm-0">
										<div class="numbers">
											<p class="card-category">Transaksi Berhasil</p>
											<h4 class="card-title">{{$ts}} Transaksi</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-4">
						<div class="card card-stats card-round border">
							<div class="card-body">
								<div class="row align-items-center">
									<div class="col-icon">
										<div class="icon-big text-center icon-danger bubble-shadow-small">
											<i class="flaticon-error"></i>
										</div>
									</div>
									<div class="col col-stats ml-3 ml-sm-0">
										<div class="numbers">
											<p class="card-category">Transaksi Batal</p>
											<h4 class="card-title">{{$tb}} Transaksi</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card border">
					<div class="card-body">
						<div class="row">
							@if (count($jh) == null)
								<div class="col-md-12 text-center">
									<h4>Belum Ada Produk terjual</h4>
								</div>
							@else
							<div class="col-md-6">
								<h4><b>PRODUK TERJUAL</b></h4>
								<div class="separator-solid"></div>
								<div class="table-responsive">
									<table class="table table-striped">
										@php
											$i = 1;
										@endphp
										
										@foreach ($jh as $jh)
											<tr>
												<td width="5%">{{$i++}}.</td>
												<td width="30%">{{$jh->nama_makanan}}</td>
												<td>{{$jh->jumlah}} Porsi</td>
											</tr>
										@endforeach

									</table>
								</div>
							</div>
							<div class="col-md-6">
								
								<h4><b>JUMLAH TRANSAKSI</b></h4>
								<div class="separator-solid"></div>
								<div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
									@foreach ($jt as $j)
										<div class="px-2 pb-2 pb-md-0 text-center">
											<div id="circles-{{$j->jenis}}"></div>
											<h6 class="fw-bold mt-3 mb-0">{{$j->jenis}}</h6>
										</div>
									@endforeach
								</div>
								
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script src="{{ asset('assets/atlantis/js/plugin/chart-circle/circles.min.js') }}"></script>
	<script>
		@php
			$a = 1;
			$b = count($jt);
			$colors = [ 1 => '#F25961','#2BB930','#FF9E27','#609dff'];
		@endphp
		@foreach ($jenis as $e)
			@foreach ($jt as $t)
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
	</script>
@endsection