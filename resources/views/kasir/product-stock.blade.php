@extends('kasir/master-d')
@section('css')	
	<style>
		#table td, #table th{
			border:1px solid grey !important;
			height: 2.7	rem !important;
		}
		#table th{
			text-transform: uppercase;
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
								<h4><b>STOK PRODUK</b></h4>
								<small>{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
							</div>
						</div>
						<div class="separator-solid"></div>
						<form action="{{ route('kasir.stok-update') }}" method="POST">
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
									<input type="submit" value="Update Stok" name="update" class="btn active btn-sm mt-2">
								</div>
							</div>
							<div class="table-responsive">
								<table class="table" id="table">
									<thead class="bg-dark text-light">
										<tr>
											<th>No</th>
											<th>Nama Makanan</th>
											<th>Stok Hari Ini</th>
											<th>Sisa Stok</th>
											<th>Update Stok</th>
										</tr>
									</thead>
									@php
										$i = 1;
									@endphp
									<tbody>
										@foreach ($products as $product)
												
											
											<tr>
												<td>{{$i++}}</td>
												<td>
													{{$product->nama_makanan}}
													<input type="hidden" name="id_produk[]" value="{{$product->id}}">
													<input type="hidden" name="id_booth" value="{{session('login')['id_booth']}}">
												</td>
												<td>
													@foreach ($stocks as $stock1)
														{{$stock1->id_produk == $product->id ? $stock1->total_stok : null}}
													@endforeach
												</td>
												<td>
													@foreach ($stocks as $stock1)
														{{$stock1->id_produk == $product->id ? $stock1->sisa_stok : null}}
													@endforeach
												</td>
												<td>
													<input type="number" name="update_stok[]" min="1" style="border-radius: 4px; border: 1px solid #aaaaaa; width: 4rem; padding-left: 0.5rem;">
												</td>
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