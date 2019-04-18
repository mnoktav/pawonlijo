@extends('kasir/master-d')
@section('css')
	
	<style>

		.table th, .table td{
			font-size: 0.85rem !important;
			height: 3rem;
		}
		.note{
			border: 1px solid #dddddd;
		}
		.note .card-body{
			background-color: #fcffcc;
		}
		.note .tanggal{
			margin-bottom: 0.5rem;
		}
	</style>

@endsection
@section('content')
	<div class="page-inner">
		<div class="row">
			@if($stok == 0)
			<div class="col-md-12 mb-2">
				<div class="alert alert-warning" role="alert">
				  Stok Belum Diupdate Untuk Hari Ini, Segera Hubungi Admin!
				</div>
			</div>
			@endif
			<div class="col-md-3 col-6" >
				<div class="card">
					<div class="card-body" style="background-color: #efefef">
						<div class="logo p-2 text-center">
							<a href="{{ url('/kasir/product?jenis=Gojek') }}" style="font-size: 1.5rem;">Gojek</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-6">
				<div class="card border">
					<div class="card-body" style="background-color: #efefef">
						<div class="logo p-2 text-center">
							<a href="{{ url('/kasir/product?jenis=Grab') }}" style="font-size: 1.5rem;">Grab</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-6">
				<div class="card border">
					<div class="card-body" style="background-color: #efefef">
						<div class="logo p-2 text-center">
							<a href="{{ url('/kasir/product?jenis=Reguler') }}" style="font-size: 1.5rem;">Reguler</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-3 col-6">
				<div class="card border">
					<div class="card-body" style="background-color: #efefef">
						<div class="logo p-2 text-center">
							<a href="{{ url('/kasir/product?jenis=Pesanan') }}" style="font-size: 1.5rem;">Pesanan</a>
						</div>
					</div>
				</div>
			</div> 
		</div>
		<div class="row">
			<div class="col-md-4 mt-3">
				<div class="card border">
					<div class="card-body">
						<h4><b>DATA HARIAN</b></h4>
						<div class="separator-solid"></div>
						<table class="table table-striped">
							<tr>
								<th>Trans. Sukses</th>
								<td>:</td>
								<td>{{$ts}}</td>
							</tr>
							<tr>
								<th>Trans. Batal</th>
								<td>:</td>
								<td>{{$tb}}</td>
							</tr>
							<tr>
								<th>Pemasukan</th>
								<td>:</td>	
								<td>Rp {{$total}}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-8 mt-3">
				<div class="card border">
					<div class="card-body">
						<h4><b>NOTE</b></h4>
						<div class="separator-solid"></div>
						<div class="row">
							@foreach($notes as $note)
							<div class="col-md-4 target">
								<div class="card note">
									<div class="card-body">
										<div class="tanggal text-right">
											<small>{{date('d/m/Y', strtotime($note->created_at))}}</small>
										</div>
										<div class="separator-solid" style="border-color: #b2b2b2"></div>
										<b>Pesan :</b><br>
										<p class="m-0" style="text-transform: capitalize; font-size: 1rem; font-weight: bolder;">{{$note->judul}}</p>
										{{$note->pesan}}
										<div class="separator-solid" style="border-color: #b2b2b2"></div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
						@if (count($notes) < 1)
							<div class="text-center">
								<h4 class="mt-2">Belum Ada Note.</h4>
							</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('js')
	
@endsection