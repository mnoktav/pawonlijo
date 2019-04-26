@extends('admin/master-d')
@section('css')
	<style>
		.card input, .card select{
			border: 1px solid #dddddd;
		}
		.table th, .table td{
			padding: 0.7rem !important;
			font-size: 0.8rem;
			border: 1px solid black !important;
			height: 1rem !important;
		}
	</style>
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
						<div class="card border shadow-sm">
							<div class="card-body">
								<h4><b>CETAK LAPORAN</b></h4>
								<div class="separator-solid"></div>
								<form action="" method="GET">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group p-0 mt--2">
												<label for="nama-booth" class="col-form-label">Booth : </label>
												<select class="form-control" name="id_booth" id="nama-booth">
													<option value="">Semua</option>
													@foreach ($booths as $booth)
														<option value="{{$booth->id_booth}}">{{$booth->nama_booth}}, {{$booth->kota_booth}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group p-0 mt--2">
												<label class="col-form-label">Tanggal Awal</label>
												<input type="date" class="form-control" required="" name="awal">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group p-0 mt--2">
												<label class="col-form-label">Tanggal Akhir</label>
												<input type="date" class="form-control" name="akhir">
											</div>
										</div>
										<div class="col-md-2 text-center mt-1 " style="padding-top: 3.5%;">
											<input type="submit" class="btn btn-primary btn-sm pl-4 pr-4" value="Cari" name="cari">
										</div>
										<div class="col-md-3">
											<p class="text-danger">* Catatan : untuk mencari data harian cukup isi tanggal awal saja</p>
										</div>
									
									</div>
								</form>
							</div>
						</div>
						<div class="card border shadow-sm" id="tabel-penjualan">
							<div class="card-body">
								@if(is_null($sales))
									<div class="text-center text-muted">
										<h4><b>Isi Form Diatas Terlebih Dahulu</b></h4>
									</div>
								@else
								<div class="col-md-12">
									<div class="text-right">
										<button type="button" class="btn btn-sm btn-rounded pr-3 pl-3" onclick="PrintPdf();"><i class="fas fa-file-pdf mr-2"></i>PDF</button>
										<button class="btn btn-sm btn-rounded pr-3 pl-3"><i class="fas fa-file-excel mr-2"></i>Excel</button>
									</div>
								</div>
								<div class="print-content">
									<div class="row">
										<div class="col-md-11 mt--1">
											<h3><b>LAPORAN PENJUALAN BOOTH CUKIR</b></h3>
											<h6>TANGGAL : 6/12/2019 - 6/12/2019</h6>
										</div>
									</div>
									<div class="separator-solid"></div>
									<div class="table-responsive">
										<table class="table table-bordered">
											<tr class="border bg-warning text-light">
												<th>TANGGAL</th>
												<th>ID TRANSAKSI</th>
												<th>JENIS</th>
												<th>KODE</th>
												<th>SUBTOTAL</th>
												<th>POTONGAN</th>
												<th>TOTAL</th>
											</tr>
											@foreach ($sales as $sale)
												
												<tr style="background-color: #efefef">
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
												</tr>
												@foreach ($detail as $d)
													@if($sale->id == $d->id_transaksi)
													<tr>
														<td></td>
														<td>{{$d->nama_makanan}}</td>
														<td>Rp {{$d->harga_satuan}}</td>
														<td>{{$d->jumlah}}</td>
														<td colspan="3"></td>
													</tr>
													@endif
												@endforeach
											@endforeach

										</table>
										{{ $sales->links() }}
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

	<script>
		function PrintPdf(){
 
		    var pdf = new jsPDF("l", "pt", "a4");
				pdf.addHTML($('.print-content'), 0, 0, function() {
				  pdf.save('div.pdf');
				});
		}
	</script>
@endsection
