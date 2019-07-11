@extends('admin/master-d')
@section('css')	
	<style>
		.table td, .table th{
			border:1px solid grey !important;	
		}
		.table th{
			text-transform: uppercase;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Stok Menu PawonLijo</h4>
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
					<a>Stok Menu PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Nama Booth</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>STOK PRODUK</b></h4>
								<small>{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.stock-product') }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<form action="{{ route('admin.stock-update') }}" method="POST">
						@csrf
							<div class="row mb-3">
								<div class="col-md-6">
									<div class="form-group" style="padding: 0;">
										<div class="input-icon">
											<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
											<span class="input-icon-addon">
												<i class="fa fa-search"></i>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-2 offset-md-4 text-right">
									<input type="submit" value="Update Stok" name="update" class="btn btn-success">
								</div>
							</div>
							<div class="table-responsive">
								<table class="table table-striped" id="table">
									<thead class="bg-dark text-light">
										<tr>
											<th>No</th>
											<th width="25%">Nama Makanan</th>
											<th>Stok Hari Ini</th>
											<th>Sisa Stok Hari Ini</th>
											<th>Update Stok</th>
											<th>Info Stok</th>
										</tr>
									</thead>
									<tbody>
										@php
											$o = 1;
										@endphp
										@foreach ($products as $product)
												
											
											<tr>
												<td>{{$o++}}</td>
												<td>
													{{$product->nama_makanan}}
													<input type="hidden" name="id_produk[]" value="{{$product->id}}">
													
												</td>
												

												<td>
													@foreach ($stocks as $stock)

														{{$stock->id_produk == $product->id ? $stock->total_stok : null}}
													@endforeach
												</td>
												<td>
													@foreach ($stocks as $stock1)
														{{$stock1->id_produk == $product->id ? $stock1->sisa_stok : null}}
													@endforeach
												</td>
												
												<td><input type="number" name="update_stok[]" min="1" style="border-radius: 4px; border: 1px solid #aaaaaa; width: 4rem; padding-left: 0.5rem;"></td>

												<td ><a href="{{ url('/admin/stock-product/'.$booth->id_booth.'/'.$product->id) }}" class="btn btn-warning btn-sm">Info</a></td>
											</tr>
											
										@endforeach
										
									</tbody>
								</table>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script>
		function Search() {
		  // Declare variables 
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById("search");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("table");
		  tr = table.getElementsByTagName("tr");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName("td")[1];
		    if (td) {
		      txtValue = td.textContent || td.innerText;
		      if (txtValue.toUpperCase().indexOf(filter) > -1) {
		        tr[i].style.display = "";
		      } else {
		        tr[i].style.display = "none";
		      }
		    } 
		  }
		}
	</script>
@endsection
