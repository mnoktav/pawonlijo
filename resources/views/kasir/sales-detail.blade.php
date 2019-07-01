@extends('kasir/master-d')
@section('css')
	<style>
		.table th, .table td{
			padding: 0.5rem !important;
			font-size: 0.85
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>{{$sale->id}}</b></h4>
								<small>{{session('login')['nama_booth']}}, {{session('login')['kota_booth']}} ({{session('login')['id_booth']}})</small><br>
							</div>
							<div class="col-md-2 text-right">
								@if (Request::segment(3) == 'pesanan')
									<a class="btn btn-sm btn-rounded btn-primary text-light" href="{{ route('kasir.transaksi-pesanan') }}">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
								@else
									<a class="btn btn-sm btn-rounded btn-primary text-light" href="{{ route('kasir.transaksi') }}">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
								@endif
								
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="card border">
							<div class="card-body">
								<div class="row mb-3">
									<div class="col-md-6">
										<h5><b>Nama Pembeli</b> : {{$sale->nama_pembeli}}</h5>
										<h5><b>Jenis Transaksi</b> : {{$sale->jenis}} @if (!empty($sale->kode))
											({{$sale->kode}})
										@endif</h5>
										<h5><b>Tanggal</b> : {{date('d/m/Y H:i',strtotime($sale->created_at))}}</h5>
									</div>
									<div class="col-md-6">
										
										@if($sale->status == 1)
										<h5><b>Status</b> : Sukses<i class="fas fa-check ml-2 text-success"></i></h5>
										@elseif($sale->status == 2)
										<h5><b>Status</b> : Pending<i class="fas fa-check ml-2 text-muted"></i></h5>
										@else
										<h5><b>Status</b> : Batal<i class="fas fa-times ml-2 text-danger"></i></h5>
										@endif
										@if($sale->status == 0)
										<p><b>Alasan Pembatalan : </b> {{$sale->keterangan}}</p>
										@else
										<p><b>Keterangan : </b> {{$sale->keterangan}}</p>
										@endif
										@if($sale->status == 1)
										<button onclick="window.open('{{ asset('storage').'/'.$sale->id.'.pdf' }}')" class="btn btn-xs btn-secondary">Cetak Nota</button>
										@endif
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped">
										<thead class="bg-dark text-light">
											<tr>
												<th>Nama Produk</th>
												<th>Harga Satuan</th>
												<th>Sub Total</th>
											</tr>
										</thead>
										<tbody>
											@foreach ($detail as $detail)
											<tr>
												<td>{{$detail->nama_makanan}}</td>
												<td>Rp {{Rupiahd($detail->harga_satuan)}} x {{$detail->jumlah}}</td>
												<td>Rp {{Rupiahd($detail->harga_satuan*$detail->jumlah)}}</td>
											</tr>
											@endforeach
											<tr>
												<td colspan="2"><b>SUBTOTAL</b></td>
												<td colspan="2">Rp {{Rupiahd($sale->subtotal)}}</td>
											</tr>
											<tr>
												<td colspan="2"><b>POTONGAN</b></td>
												<td colspan="2">Rp {{Rupiahd($sale->potongan)}}</td>
											</tr>
											<tr>
												<td colspan="2"><b>TOTAL</b></td>
												<td colspan="2">Rp {{Rupiahd($sale->total)}}</td>
											</tr>
											<tr>
												<td><b>BAYAR</b></td>
												<td>Rp {{Rupiahd($sale->bayar)}}</td>
											</tr>
											<tr>
												<td><b>KEMBALI</b></td>
												<td>Rp {{Rupiahd($sale->kembali)}}</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="separator-solid"></div>
								<div class="text-center">
									<button type="button" class="btn btn-sm btn-rounded btn-danger {{$sale->status == 0 || $sale->jenis == 'Pesanan' && $sale->status == 1 ? 'd-none' : null}}" data-toggle="modal" data-target=".bd-example-modal-sm ">Batalkan Transaksi</button>
									
									<a href="{{ route('kasir.transaksi-update-pesanan', $sale->id) }}" class="btn btn-sm btn-rounded btn-success {{$sale->status != 2 ? 'd-none' : null}}">Transaksi Selesai</a>
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
