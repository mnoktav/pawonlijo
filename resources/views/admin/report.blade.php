@extends('admin/master-d')
@section('css')
	<style>
		.card input, .card select{
			border: 1px solid #dddddd;
		}
		.table th, .table td{
			padding: 0.7rem !important;
			font-size: 0.8rem;
			height: 1rem !important;
		}
	</style>
	{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"> --}}
@endsection
@section('content')	
	<div class="page-inner">
		<div id="loading" style="display:none">
			  Loading...
		</div>
		<div class="page-header">
			<h4 class="page-title">Laporan Penjualan</h4>
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
					<a>Laporan Penjualan</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<div class="card border shadow-sm">
									<div class="card-body">
										<h4><b>CETAK LAPORAN</b></h4>
										<div class="separator-solid"></div>
										<form action="" method="GET" id="Cari">
											<div class="form-group p-0 mb-1">
												<label for="nama-booth" class="col-form-label">Booth : </label>
												<select class="form-control" name="id_booth" id="nama-booth">
													<option value="">Semua</option>
													@foreach ($booths as $booth)
														<option value="{{$booth->id_booth}}" id="booth" {{$id_booth == $booth->id_booth ? 'selected' : null}}>{{$booth->nama_booth}}, {{$booth->kota_booth}}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group p-0 mb-1">
												<label class="col-form-label">Tanggal Awal</label>
												<input type="date" class="form-control" required="" name="awal" value="{{$awal}}" id="awal">
											</div>
											<div class="form-group p-0 mb-1">
												<label class="col-form-label">Tanggal Akhir</label>
												<input type="date" class="form-control" name="akhir" value="{{$akhir}}" id="akhir">
											</div>
											<input type="submit" class="btn btn-primary btn-sm btn-block mt-3" value="Cari" name="cari" id="cari">
											<p class="text-danger mt-3">* Catatan : untuk mencari data harian cukup isi tanggal awal saja</p>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-9">
								<div class="card border shadow-none" id="tabel-penjualan">
									<div class="card-body">
										
										@if(is_null($sales))
											<div class="text-center text-muted">
												<h4 style="text-transform: uppercase; padding: 26% 0"><b>Isi Terlebih Dahulu Form Disamping ...</b></h4>
											</div>
										@elseif(count($sales) == null)
											<div class="text-center text-muted">
												<h4><b>Tidak Ada Transaksi</b></h4>
											</div>
										@else
										<div class="laporan">
											<h4><b>LAPORAN</b></h4>
											<div class="separator-solid"></div>
										
											<table class="table table-borderless">
												<tr>
													<th>Booth</th>
													<td>:</td>
													<td>
														@if (empty($id_booth))
															Semua Booth Pawon Lijo
														@else
															{{$id_booth}}
														@endif
													</td>
												</tr>
												<tr>
													<th>Tanggal</th>
													<td>:</td>
													@if (!empty($akhir))
														<td>{{date('d F Y', strtotime($awal))}}  s/d  {{date('d F Y', strtotime($akhir))}}</td>
													@else
														<td>{{date('d F Y', strtotime($awal))}}</td>
													@endif
												</tr>
											</table>
											<div class="row mt-4">
												<div class="col-md-6">
													<div class="card card-pricing border shadow-none">
														<div class="card-header">
															<h4 class="card-title"><b>Download Excel</b></h4>
															<div class="card-price mt-4">
																<i class="fas fa-file-excel fa-5x" style="color: #3b8247 "></i>
															</div>
														</div>
														<div class="card-footer">
															<button onclick="window.open('../admin/report/excel?awal={{$awal}}&akhir={{$akhir}}&id_booth={{$id_booth}}')" class="btn btn-primary pr-3 pl-3 mr-2">Download</button>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="card card-pricing shadow-none border">
														<div class="card-header">
															<h4 class="card-title"><b>Download PDF</b></h4>
															<div class="card-price mt-4">
																<i class="fas fa-file-pdf fa-5x" style="color: #c62e23"></i>
															</div>
														</div>
														<div class="card-footer">
															<button onclick="window.open('../admin/report/pdf?awal={{$awal}}&akhir={{$akhir}}&id_booth={{$id_booth}}')" class="btn btn-primary pr-3 pl-3 mr-2">Download</button>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										{{-- <div>
											
										</div> --}}
										
										{{-- <div class="print-content">
											
											<div class="separator-solid"></div>
											
											<iframe src="" style="height: 600px; width:100%">
											</iframe>

											
											

										</div> --}}
										@endif
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
@if (Session::has('sweet_alert.alert'))
    <script>
    $(document).ready(function(){
        swal({
            text: "{!! Session::get('sweet_alert.text') !!}",
            title: "{!! Session::get('sweet_alert.title') !!}",
            imageUrl: "{{ asset('assets/img/loading.gif') }}",
            timer: 3000,
            button : false,
            closeOnClickOutside: false,
        });
    });
    </script>
@endif
@endsection
