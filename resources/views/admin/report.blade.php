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
										<form action="" method="GET">
											<div class="form-group p-0 mb-1">
												<label for="nama-booth" class="col-form-label">Booth : </label>
												<select class="form-control" name="id_booth" id="nama-booth">
													<option value="">Semua</option>
													@foreach ($booths as $booth)
														<option value="{{$booth->id_booth}}" {{$id_booth == $booth->id_booth ? 'selected' : null}}>{{$booth->nama_booth}}, {{$booth->kota_booth}}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group p-0 mb-1">
												<label class="col-form-label">Tanggal Awal</label>
												<input type="date" class="form-control" required="" name="awal" value="{{$awal}}">
											</div>
											<div class="form-group p-0 mb-1">
												<label class="col-form-label">Tanggal Akhir</label>
												<input type="date" class="form-control" name="akhir" value="{{$akhir}}">
											</div>
											<input type="submit" class="btn btn-primary btn-sm btn-block mt-3" value="Cari" name="cari">
											<p class="text-danger mt-3">* Catatan : untuk mencari data harian cukup isi tanggal awal saja</p>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-9">
								<div class="card shadow-none" id="tabel-penjualan">
									<div class="card-body">
										@if(is_null($sales))
											<div class="text-center text-muted border mt--3">
												<h4 style="text-transform: uppercase; padding: 28% 0"><b>Isi Terlebih Dahulu Form Disamping ...</b></h4>
											</div>
										@elseif(count($sales) == null)
											<div class="text-center text-muted">
												<h4><b>Tidak Ada Transaksi</b></h4>
											</div>
										@else
										
										<div>
											<a class="btn btn-default btn-sm pr-3 pl-3 mr-2" href="/admin/report/excel?awal={{$awal}}&akhir={{$akhir}}&id_booth={{$id_booth}}" target="_blank"><i class="fas fa-file-excel mr-2"></i>Export to Excel</a>
										</div>
							
										<div class="print-content">
											
											<div class="separator-solid"></div>
											
											<iframe src="/admin/report/pdf?awal={{$awal}}&akhir={{$akhir}}&id_booth={{$id_booth}}" style="height: 600px; width:100%">
											</iframe>

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
	</div>
@endsection
@section('js')
	{{-- <script src="{{ asset('assets/atlantis/js/plugin/datatables/datatables.min.js') }}"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
	<script>
		$(document).ready(function() {
			$('.transaksi').DataTable({
				dom: 'Bfrtip',
		        buttons: [
		            'copy', 'csv', 'excel', 'pdf', 'print'
		        ]
			});
		})
	</script> --}}
@endsection
