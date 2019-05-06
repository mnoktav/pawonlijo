@extends('kasir/master-d')
@section('css')
	<style>

		#basic-datatables th, #basic-datatables td{
			font-size: 0.8rem !important;
			padding: 0.5rem !important;
			height: 2.5rem;
		}

	</style>
@endsection
@section('content')
	<div class="page-inner">
		<div class="card">
			<div class="card-body">
				<h4 style="text-transform: uppercase;"><b>TRANSAKSI PENJUALAN {{session('login')['nama_booth']}}</b></h4>
				<div class="separator-solid"></div>
				<div class="table-responsive">
					<table id="basic-datatables" class="display table table-striped" style="padding: 0px;">
						<thead class="bg-dark text-light">
							<tr>
								<th>Tanggal</th>
								<th>ID. Transaksi</th>
								<th class="d-none d-sm-table-cell">Jenis</th>
								<th class="d-none d-sm-table-cell">Kode</th>
								<th class="d-none d-sm-table-cell">Subtotal</th>
								<th class="d-none d-sm-table-cell">Potongan</th>
								<th class="d-none d-sm-table-cell">Total</th>
								<th class="d-none d-sm-table-cell">Status</th>
								<th width="8%">Detail</th>
							</tr>
						</thead>
						<tbody>
							@foreach($sales as $sale)
							<tr>
								<td>{{date('d/m/Y H:i',strtotime($sale->created_at))}}</td>
								<td>{{$sale->id}}</td>
								<td class="d-none d-sm-table-cell">{{$sale->jenis}}</td>
								@if($sale->kode != null)
								<td class="d-none d-sm-table-cell">{{$sale->kode}}</td>
								@else
								<td class="d-none d-sm-table-cell">-</td>
								@endif
								<td class="d-none d-sm-table-cell">Rp {{Rupiahd($sale->subtotal)}}</td>
								<td class="d-none d-sm-table-cell">Rp {{Rupiahd($sale->potongan)}}</td>
								<td class="d-none d-sm-table-cell">Rp {{Rupiahd($sale->total)}}</td>
								@if($sale->status == 1)
								<td class="d-none d-sm-table-cell">Sukses</td>
								@else
								<td class="d-none d-sm-table-cell">Batal</td>
								@endif
								<td>
									<a href="{{ route('kasir.transaksi-detail',$sale->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-info"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>		
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script src="{{ asset('assets/atlantis/js/plugin/datatables/datatables.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
				 aaSorting: [[0, 'desc']]
			});
		})
	</script>
@endsection