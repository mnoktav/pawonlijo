@extends('admin/master-d')
@section('css')
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
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Detail</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$sale->id}}</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>{{$sale->id}}</b></h4>
								<small>{{$booth->nama_booth}}, {{$booth->kota_booth}} ({{$booth->id_booth}})</small><br>
							</div>
							<div class="col-md-2 text-right text-light">
								<a class="btn btn-sm btn-rounded btn-primary" onclick="window.history.back()" {{-- href="{{ route('admin.sales') }}" --}}>
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="card border">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-md-6">
										<h5><b>Nama Pembeli</b> : {{$sale->nama_pembeli}}</h5>
										<h5><b>Jenis Transaksi</b> : {{$sale->jenis}} ({{$sale->id}})</h5>
									</div>
									<div class="col-md-6">
										<h5><b>Tanggal</b> : {{date('d/m/Y H:i',strtotime($sale->created_at))}}</h5>
										@if($sale->status == 1)
										<h5><b>Status</b> : Sukses<i class="fas fa-check ml-2 text-success"></i></h5>
										@elseif($sale->status == 2)
										<h5><b>Status</b> : Pending<i class="fas fa-check ml-2 text-muted"></i></h5>
										@else
										<h5><b>Status</b> : Batal<i class="fas fa-times ml-2 text-danger"></i></h5>
										@endif
										@if($sale->status == 0)
										<p><b>Alasan Pembatalan : </b> {{$sale->keterangan}}</p>
										@elseif($sale->jenis == 'Pesanan')
										<p><b>Keterangan : </b> {{$sale->keterangan}}</p>
										@endif
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="bg-dark text-light">
											<tr>
												<th>Nama Produk</th>
												<th>Harga Satuan</th>
												<th>Jumlah</th>
												<th>Sub Total</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($detail as $detail)
											<tr>
												<td>{{$detail->nama_makanan}}</td>
												<td>Rp {{Rupiah($detail->harga_satuan)}}</td>
												<td>{{$detail->jumlah}}</td>
												<td>Rp {{Rupiah($detail->harga_satuan*$detail->jumlah)}}</td>
											</tr>
											@endforeach
											<tr>
												<td colspan="3"><b>SUBTOTAL</b></td>
												<td>Rp {{Rupiah($sale->subtotal)}}</td>
											</tr>
											<tr>
												<td colspan="3"><b>DISCOUNT BOOTH</b></td>
												<td>Rp {{Rupiah($sale->potongan)}}</td>
											</tr>
											<tr>
												<td colspan="3"><b>TOTAL</b></td>
												<td><b> Rp {{Rupiah($sale->total)}}</b></td>
											</tr>
											<tr>
												<td colspan="3"><b>TOTAL BERSIH (PAJAK {{$sale->pajak}}%)</b></td>
												<td><b>Rp {{Rupiah($sale->total_bersih)}} &nbsp;&nbsp;&nbsp;(Rp {{Rupiah($sale->subtotal*$sale->pajak/100)}})</b></td>
											</tr>
											<tr>
												<td><b>BAYAR</b></td>
												<td>Rp {{Rupiah($sale->bayar)}}</td>
											</tr>
											<tr>
												<td><b>KEMBALI</b></td>
												<td>Rp {{Rupiah($sale->kembali)}}</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="text-center">
									<button type="button" class="btn btn-sm btn-rounded btn-danger {{$sale->status == 0 || $sale->jenis == 'Pesanan' || $sale->status == 1 ? 'd-none' : null}}" data-toggle="modal" data-target=".bd-example-modal-sm ">Batalkan Transaksi</button>
									<a href="{{ route('admin.transaksi-update-pesanan', $sale->id) }}" class="btn btn-sm btn-rounded btn-success {{$sale->status != 2 ? 'd-none' : null}}">Transaksi Selesai</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade bd-example-modal-sm mt-4" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  	<div class="modal-dialog modal-sm">
	    	<div class="modal-content">
	    		<form action="{{ route('kasir.transaksi-batal') }}" method="POST">
	    			@csrf
		      		<div class="modal-header">
				        <h5 class="modal-title">Transaksi Batal</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <div class="modal-body">
				        <div class="form-group">
				        	<label for="">ID Transaksi</label>
				        	<input type="text" class="form-control" name="id" value="{{$sale->id}}" readonly>
				        </div>
				        <div class="form-group">
				        	<label for="">Alasan Pembatalan</label>
				        	<textarea name="keterangan" class="form-control" required=""></textarea>
				        </div>
				        <p class="text-danger p-2">Transaksi yang sudah dibatalkan tidak bisa dikembalikan!</p>
				    </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				        <input type="submit" class="btn btn-primary btn-sm" name="batal" value="Update">
				    </div>
			    </form>
	    	</div>
	  	</div>
	</div>
@endsection
