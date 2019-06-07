@extends('admin/master-d')
@section('css')
	<style>
	.list {
		border: 1px solid #dddddd;
	}
	.list h5{
		text-transform: uppercase;
		margin-bottom: 0;
	}
	.harga th, .harga td{
		padding: 0.3rem 0.4rem;
		font-size: 0.75rem;
		border-radius: 1rem;
	}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Daftar Menu PawonLijo</h4>
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
					<a>Daftar Menu</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$booth->nama_booth}}</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>DAFTAR MENU</b></h4>
								<small style="text-transform: uppercase;">{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
								<small>TOTAL PRODUK : {{$jumlah}}</small>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.product') }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="card" style="border: 1px solid #dddddd">
									<div class="card-body">
										<div class="row">
											<div class="col-md-6">
												<ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
													<li class="nav-item">
														<a class="nav-link active" id="pills-square-tab" data-toggle="pill" href="#pills-square" role="tab" aria-controls="pills-square" aria-selected="true"><i class="fas fa-th"></i></a>
													</li>
													<li class="nav-item">
														<a class="nav-link " id="pills-table-tab" data-toggle="pill" href="#pills-table" role="tab" aria-controls="pills-table" aria-selected="true"><i class="fas fa-trash"></i></a>
													</li>
													
												</ul>
											</div>
											<div class="col-md-6 mt-1">
												<div class="form-group" style="padding: 0; margin-bottom: 1rem;">
													<div class="input-icon">
														<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
														<span class="input-icon-addon">
															<i class="fa fa-search"></i>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="separator-solid mt--1" style=""></div>
										<div class="tab-content mt-2 mb-3" id="pills-tabContent">
											<div class="tab-pane fade" id="pills-table" role="tabpanel" aria-labelledby="pills-table-tab">
												<div class="row">
													@if (count($menus_d) <= 0)
													<div class=" col-md-12 text-center mt-3">
														<h3>Tidak ada menu yang dihapus.</h3>
													</div>
													@endif
													@foreach($menus_d as $menu_d)
													<div class="col-md-3 target">
														<div class="card shadow-none list full-height" style="background-color: #f7f7f7">
															<div class="card-body">
																<h5 style="text-transform: capitalize;"><i class="fas fa-tag text-danger mr-2"></i><b>{{$menu_d->nama_makanan}}</b></h5>
																<small class="ml-4" style="text-transform: capitalize;">{{$menu_d->kategori}}</small>
																<div class="separator-solid mt-2 mb-2" style="margin: 0"></div>
																<div class="harga d-flex justify-content-center text-center">
																	<table>
																		@foreach ($harga as $h)
																			@if ($h->id_produk == $menu_d->id)
																			<tr>
																				<th>{{$h->jenis_transaksi}}</th>
																				<td>:</td>
																				<td>Rp {{Rupiahd($h->harga)}}</td>
																			</tr>
																			@endif
																		@endforeach
																	</table>
																</div>
																<div class="separator-solid mt-2 mb-3" style="margin: 0"></div>
																<div class="button text-center">
																	<a href="{{ route('admin.product-back',$menu_d->id) }}" class="btn btn-icon btn-round btn-warning btn-sm b-produk">
																		<i class="fas fa-sync mt-2"></i>
																	</a>
																	<a href="{{ route('admin.product-deletep',$menu_d->id) }}" class="btn btn-icon btn-round btn-danger btn-sm dp-produk">
																		<i class="fas fa-trash mt-2"></i>
																	</a>
																</div>
															</div>
														</div>
													</div>
													@endforeach
												</div>
											</div>
											<div class="tab-pane fade show active" id="pills-square" role="tabpanel" aria-labelledby="pills-square-tab">
												<div class="row">
													
													@foreach($menus as $menu1)
													<div class="col-md-3 target">
														<div class="card shadow-none list full-height" style="background-color: #f7f7f7">
															<div class="card-body">
																<h5 style="text-transform: capitalize;"><i class="fas fa-tag text-danger mr-2"></i><b>{{$menu1->nama_makanan}}</b></h5>
																<small class="ml-4" style="text-transform: capitalize;">{{$menu1->kategori}}</small>
																<div class="separator-solid mt-2 mb-2" style="margin: 0"></div>
																<div class="harga d-flex justify-content-center text-center">
																	<table>
																		@foreach ($harga as $h)
																			@if ($h->id_produk == $menu1->id)
																			<tr>
																				<th>{{$h->jenis_transaksi}}</th>
																				<td>:</td>
																				@if ($h->harga != null)
																					<td>Rp {{Rupiahd($h->harga)}}</td>
																				@else
																					<td>-</td>
																				@endif
																				
																			</tr>
																			@endif
																		@endforeach
																	</table>
																</div>
																
															</div>
															<di class="card-footer">
																<div class="button text-center">
																	<a href="/admin/product/booth/{{$booth->id_booth.'/'.$menu1->id}}" class="btn btn-icon btn-round btn-primary btn-sm">
																		<i class="fas fa-info mt-2"></i>
																	</a>

																	<a href="/admin/product/booth/{{$booth->id_booth}}/edit/{{$menu1->id}}" class="btn btn-icon btn-round btn-warning btn-sm">
																		<i class="fas fa-pen mt-2"></i>
																	</a>

																	<a href="{{ route('admin.product-delete',$menu1->id) }}" class="btn btn-icon btn-round btn-danger btn-sm n-produk">
																		<i class="fas fa-trash mt-2"></i>
																	</a>
																</div>
															</di>
														</div>
													</div>
													@endforeach
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script>
		function Search() {
		  var input = document.getElementById("search");
		  var filter = input.value.toLowerCase();
		  var nodes = document.getElementsByClassName('target');

		  for (i = 0; i < nodes.length; i++) {
		    if (nodes[i].innerText.toLowerCase().includes(filter)) {
		      nodes[i].style.display = "block";
		    } else {
		      nodes[i].style.display = "none";
		    }
		  }
		}
	</script>
	<script>
		$(document).ready(function(){
		    $('.n-produk').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin menonaktifkan produk ini?",
		            text: message, 
		            icon: "warning",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
		          if (willDelete) {
		            window.location.href = href;
		          }
		        });
		    });
		});
	</script>
	<script>
		$(document).ready(function(){
		    $('.b-produk').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin mengaktifkan produk ini?",
		            text: message, 
		            icon: "warning",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
		          if (willDelete) {
		            window.location.href = href;
		          }
		        });
		    });
		});
	</script>
	<script>
		$(document).ready(function(){
		    $('.dp-produk').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin menghapus produk ini secara permanen?",
		            text: message, 
		            icon: "warning",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
		          if (willDelete) {
		            window.location.href = href;
		          }
		        });
		    });
		});
	</script>
@endsection

