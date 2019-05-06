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
			<h4 class="page-title">Jenis Transaksi Booth PawonLijo</h4>
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
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							@foreach ($jenis as $j)
							<div class="col-md-3">
								<div class="card card-pricing border">
									<div class="card-header">
										<h4 class="card-title">{{$j->jenis_transaksi}}</h4>
										<div class="card-price">
											<span class="price">{{$j->pajak}}%</span><br>
											<span>Pajak</span>
										</div>
									</div>
									<div class="card-footer">
										<button class="btn btn-block btn-primary open-edit" data-target=".bd-example-modal-sm" data-toggle="modal" data-id="{{$j->id}}" data-pajak="{{$j->pajak}}" data-nama="{{$j->jenis_transaksi}}"><b>Edit Pajak</b></button>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						<div class="separator-solid mt--2"></div>
						<div class="row mt-2">
							{{-- <div class="col-md-3 offset-md-9">
								<select name="" id="" class="form-control mb-3" style="border-color: #c4c4c4;">
									<option value="">Hari Ini</option>
									<option value="">Minggu Ini</option>
								</select>
							</div> --}}
							<div class="col-md-12">
								<table class="table table-striped pajak">
									<thead class="bg-warning text-light">
										<tr>
											<th>Tanggal</th>
											<th>Nama Booth</th>
											<th>Jenis Transaksi</th>
											<th>Pajak</th>
											<th>Detail</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($tax as $t)
										<tr>
											<td>{{date('d/m/Y', strtotime($t->tanggal))}}</td>
											@foreach ($booths as $b)
												@if ($b->id_booth == $t->id_booth)
													<td>{{$b->nama_booth.', '.$b->kota_booth}} ({{$t->id_booth}})</td>
												@endif
											@endforeach
											<td>{{$t->jenis}}</td>
											<td>Rp {{Rupiahd($t->pajak)}}</td>
											<td><a href="" class="btn btn-primary btn-sm btn-rounded">Detail</a></td>
										</tr>
										@endforeach
									</tbody>
								</table>
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
	    		<form action="{{ route('admin.pajak-booth-transaksi') }}" method="POST">
	    			@csrf
		      		<div class="modal-header">
				        <h5 class="modal-title">Edit Transaksi</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				    </div>
				    <div class="modal-body">
				        <div class="form-group">
				        	<label for="">Nama Transaksi</label>
				        	<input type="text" class="form-control" id="nama_transaksi" name="jenis_transaksi" value="" readonly>
				        </div>
				        <div class="form-group">
				        	<label for="">Pajak</label>
				        	<input type="number" min="0" class="form-control" name="pajak" id="pajak" value="">
				        </div>
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
@section('js')
	<script>
		$(document).on("click", ".open-edit", function (e) {
			var id = $(this).data('id');
			var nama_transaksi = $(this).data('nama');
			var pajak = $(this).data('pajak');

     		$(".modal-body #id_jenis").val(id);
     		$(".modal-body #nama_transaksi").val(nama_transaksi);
     		$(".modal-body #pajak").val(pajak);
		});
	</script>
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