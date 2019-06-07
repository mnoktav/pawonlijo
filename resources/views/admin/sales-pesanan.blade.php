@extends('admin/master-d')
@section('css')
	<style>

		#basic-datatables th, #basic-datatables td{
			font-size: 0.8rem !important;
			padding: 0.5rem !important;
			height: 2.5rem;
		}
		#basic-datatables th{
			text-transform: uppercase;
		}
	</style>
@endsection
@section('content')
	<div class="page-inner">
		<div class="card">
			<div class="card-body">
				<h4 style="text-transform: uppercase;"><b>PESANAN</b></h4>
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
								<th class="d-none d-sm-table-cell">Discount</th>
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
								<td class="d-none d-sm-table-cell">Rp {{Rupiahd($sale->total_bersih)}}</td>
								@if($sale->status == 2)
								<td class="d-none d-sm-table-cell">Pending</td>
								@elseif($sale->status == 1)
								<td class="d-none d-sm-table-cell">
									Selesai <br><small>{{date('d/m/Y H:i', strtotime($sale->updated_at))}}</small>
								</td>
								@else
								<td class="d-none d-sm-table-cell">Batal</td>
								@endif
								<td>
									<a href="{{ route('admin.pesanan-detail',$sale->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-info"></i></a>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
	<script>
		$(document).ready(function() {
			$.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );
			$('#basic-datatables').DataTable({
				 aaSorting: [[0, 'desc']],
				 columnDefs: [{
				    target: 0,
				    type: 'datetime-moment'
				  }],
				 "pageLength": 25
			});
		})
	</script>
@endsection