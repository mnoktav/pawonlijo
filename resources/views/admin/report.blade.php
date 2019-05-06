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
														<option value="{{$booth->id_booth}}" {{$id_booth == $booth->id_booth ? 'selected' : null}}>{{$booth->nama_booth}}, {{$booth->kota_booth}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group p-0 mt--2">
												<label class="col-form-label">Tanggal Awal</label>
												<input type="date" class="form-control" required="" name="awal" value="{{$awal}}">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group p-0 mt--2">
												<label class="col-form-label">Tanggal Akhir</label>
												<input type="date" class="form-control" name="akhir" value="{{$akhir}}">
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
										<h4><b>Isi Terlebih Dahulu Form Diatas</b></h4>
									</div>
								@elseif(count($sales) == null)
									<div class="text-center text-muted">
										<h4><b>Tidak Ada Transaksi</b></h4>
									</div>
								@else
								<div class="col-md-12">
									<div class="text-right">
										<a class="btn btn-default btn-sm btn-rounded pr-3 pl-3 mr-2" href="{{ route('admin.report-pdf') }}"><i class="fas fa-file-pdf mr-2"></i>PDF</a>
										<button class="btn btn-sm btn-rounded pr-3 pl-3"><i class="fas fa-file-excel mr-2"></i>Excel</button>
									</div>
								</div>
								<div class="print-content">
									
									<div class="separator-solid"></div>
									<div class="row">
										@if ($id_booth == null)
											<div class="col-md-11 mt--1">
												<h3><b>LAPORAN PENJUALAN SEMUA BOOTH PAWON LIJO</b></h3>
												@if ($akhir == '' || $akhir==$awal)
													<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}}</h4>
													
												@else
													<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}} - {{date('d/m/Y', strtotime($akhir))}}</h4>
												@endif
												
											</div>
										@else
											<div class="col-md-11 mt--1">
												<h3 style="text-transform: uppercase;"><b>LAPORAN PENJUALAN {{$nb->nama_booth}}, {{$nb->kota_booth}} (#{{$id_booth}})</b></h3>
												@if ($akhir == '' || $akhir==$awal)
													<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}}</h4>
													
												@else
													<h4>TANGGAL : {{date('d/m/Y', strtotime($awal))}} - {{date('d/m/Y', strtotime($akhir))}}</h4>
												@endif
											</div>
										@endif
										
									</div>
									<div class="table-responsive mt-2">
										<table class="table table-bordered transaksi border">
											<thead>
												<tr class="border bg-warning text-light">
													<th>TANGGAL</th>
													<th>ID TRANSAKSI</th>
													<th>JENIS</th>
													<th>KODE</th>
													<th>SUBTOTAL</th>
													<th>PAJAK</th>
													<th>DISCOUNT</th>
													<th>TOTAL</th>
												</tr>
											</thead>
											<tbody>
												@php
													$total_b = 0;
												@endphp
												@foreach ($sales as $sale)
													
													<tr style="background-color: #e0e0e0">
														<td>{{date('d/m/Y H:i',strtotime($sale->created_at))}}</td>
														<td>{{$sale->id}}</td>
														<td>{{$sale->jenis}}</td>
														@if($sale->kode != null)
														<td>{{$sale->kode}}</td>
														@else
														<td>-</td>
														@endif
														<td>Rp {{$sale->subtotal}}</td>
														<td>{{$sale->pajak}}%</td>
														<td>Rp {{$sale->potongan}}</td>
														<td>Rp {{$sale->total_bersih}}</td>
													</tr>
													<tr style="background-color: #f9f9f9;">
														<td>Detail : </td>
														<td>Nama Makanan </td>
														<td>Harga</td>
														<td colspan="5">Jumlah</td>
													</tr>
													@foreach ($detail as $d)
														@if($sale->id == $d->id_transaksi)
														<tr style="background-color: #f9f9f9;">
															<td></td>
															<td>{{$d->nama_makanan}}</td>
															<td>Rp {{$d->harga_satuan}}</td>
															<td>{{$d->jumlah}}</td>
															<td colspan="4"></td>
														</tr>
														@endif
													@endforeach
													@php
													
														$total_b += $sale->total_bersih;
													@endphp
												@endforeach
												
											</tbody>
										</table>
										<div style="float: right;">
											{{$sales->links()}}
										</div>
									</div>
									<div class="row mt-3">
										<div class="col-md-6">
											<table class="table table-bordered">
												<tr class="bg-warning text-light">
													<th colspan="2" style="text-transform: uppercase;">Produk Terjual</th>
												</tr>
												<tr>
													<th>Nama Produk</th>
													<th>Jumlah</th>
												</tr>
												@foreach ($pj as $p)
												<tr>
													<td>{{$p->nama_makanan}}</td>
													<td>{{$p->jumlah}} Porsi</td>
												</tr>
												@endforeach
											</table>
										</div>
										
										<div class="col-md-6">
											<table class="table table-bordered">
												<tr class="bg-warning text-light">
													<th colspan="4" style="text-transform: uppercase;">total Pendapatan</th>
												</tr>
												<tr>
													<th>Jenis</th>
													<th>Transaksi</th>
													<th>Pajak</th>
													<th>Total Bersih</th>
												</tr>
												@php
													$pt = 0;
													$t = 0;
												@endphp
												@foreach ($pjk as $pk)
													<tr>
														<td>{{$pk->jenis}}</td>
														<td>{{$pk->trans}}</td>
														<td>Rp {{$pk->t_pajak}}</td>
														<td>Rp {{$pk->total_b}}</td>

													</tr>
													@php
														$pt += $pk->t_pajak;
														$t += $pk->trans
													@endphp
												@endforeach
												<tr>
													<th>Total</th>
													<th>{{$t}}</th>
													<th style="text-transform: capitalize;">
														Rp {{$pt}}
													</th>
													<th style="text-transform: capitalize;">
														Rp {{$total_b}}
													</th>

												</tr>									
											</table>
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
