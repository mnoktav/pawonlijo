@extends('admin/master-d')
@section('css')
	<style>
		.table th, .table td{
			height: 2.5rem !important;
			padding: 0.5rem !important;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Detail Pajak Harian</h4>
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
					<a>Pajak</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Detail</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<table class="table table-striped">
							<thead class="bg-warning text-light">
								<tr>
									<th>Tanggal</th>
									<th>ID Transaksi</th>
									<th>Jenis Transaksi</th>
									<th>Kode</th>
									<th>Pajak</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($detail as $d)
								<tr>
									<td>{{date('d/m/Y H:i',strtotime($d->created_at))}}</td>
									<td><a href="{{ route('admin.sales-tax',$d->id) }}">{{$d->id}}</a></td>
									<td>{{$d->jenis}}</td>
									<td>{{$d->kode}}</td>
									<td>Rp {{Rupiah($d->total_pajak)}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
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
			$.fn.dataTable.moment( 'DD/MM/YYYY' );
			$('.pajak').DataTable({
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