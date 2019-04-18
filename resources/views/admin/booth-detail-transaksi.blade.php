@extends('admin/booth-detail')
@section('css')
	<style>
		#basic-datatables th, #basic-datatables td{
			padding: 0.5rem !important;
			font-size: 0.8rem;
			height: 2.5rem;
		}
	</style>
@endsection
@section('content2')	
	{{-- transaksi --}}
	<div class="card" style="border: 1px solid #dddddd;">
		<div class="card-body">
			<h4><b><span class="fas fa-list-ol text-warning"></span>&nbsp; Transaksi</b></h4>
			<div class="separator-solid"></div>
			<div class="table-responsive">
				<table id="basic-datatables" class="display table table-striped table-hover" style="padding: 0px;">
					<thead class="bg-dark text-light">
						<tr>
							<th>Tanggal</th>
							<th>ID. Transaksi</th>
							<th>Jenis</th>
							<th>Kode</th>
							<th>Subtotal</th>
							<th>Potongan</th>
							<th>Total</th>
							<th>Status</th>
							<th>Detail</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($sales as $sale)
						<tr>
							<td>{{date('d/m/Y H:i', strtotime($sale->created_at))}}</td>
							<td>{{$sale->id}}</td>
							<td>{{$sale->jenis}}</td>
							<td>{{$sale->kode}}</td>
							<td>Rp {{$sale->subtotal}}</td>
							<td>Rp {{$sale->potongan}}</td>
							<td>Rp {{$sale->total}}</td>
							@if($sale->status == 2)
							<td class="d-none d-sm-table-cell">Pending</td>
							@elseif($sale->status == 1)
							<td class="d-none d-sm-table-cell">
								Selesai <br><small>{{date('d/m/Y H:i', strtotime($sale->updated_at))}}</small>
							</td>
							@else
							<td class="d-none d-sm-table-cell">Batal</td>
							@endif
							<td><a href="{{ route('admin.sales-detail',$sale->id) }}" class="btn btn-primary btn-sm btn-rounded">Detail</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>		
			</div>
		</div>
	</div>
	{{-- end transaksi --}}
@endsection