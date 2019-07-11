@extends('admin/master-d')
@section('css')
	<style>
		.edit-makanan input{
			border:1px solid #dddddd;
		}
		.edit-makanan label{
			text-transform: uppercase;
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
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$menu->nama_makanan}}</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>{{$menu->nama_makanan}}</b></h4>
								<small style="text-transform: uppercase;">{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.product-booth-menu',$booth->id_booth) }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="row">
							<div class="col-md-8 offset-md-2">
								<div class="card" style="border: 1px solid #dddddd">
									<div class="card-body">
										<h4><b>EDIT</b></h4>
										<div class="separator-solid"></div>
										<form action="{{ route('admin.product-update') }}" method="POST" enctype="multipart/form-data">
											@csrf
											<div class="edit-makanan">
												<div class="form-group">
													<label for="id_booth">ID Booth</label>
													<input type="text" class="form-control" id="id_booth" name="id_booth" readonly="" value="{{$booth->id_booth}}">
													<input type="hidden" name="id_makanan" value="{{$menu->id}}">
												</div>
												<div class="form-group {{$errors->has('nama_makanan') ? 'has-error' : null}}">
													<label for="nama">Nama Makanan</label>
													<input type="text" class="form-control" id="nama_makanan" name="nama_makanan" value="{{$menu->nama_makanan}}" readonly="">
													@if ($errors->has('nama_makanan'))
														<span class="help-block text-danger">
															{{$errors->first('nama_makanan')}}
														</span>
													@endif
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label for="harga">Jenis Transaksi</label>
														</div>
													</div>
													@foreach ($harga as $h)
													<div class="col-md-3 mt--4">
														<div class="form-group">
															<small style="text-transform: uppercase;">{{$h->jenis_transaksi}}</small>
															<input type="text" class="form-control" id="harga" name="harga[]" value="{{$h->harga}}" onkeypress="return NumberOnly(event)">
															<input type="hidden" name="id_harga[]" value="{{$h->id}}">
														</div>
													</div>
													@endforeach
												</div>
												<div class="form-group">
													<label for="kategori">Kategori</label>
													<select name="kategori" id="kategori" class="form-control">
														<option value="makanan" {{$menu->kategori === 'makanan' ? 'selected' : null}}>Makanan</option>
														<option value="minuman" {{$menu->kategori === 'minuman' ? 'selected' : null}}>Minuman</option>
													</select>
												</div>
												<div class="row">
													
													<div class="col-md-9">
														<div class="form-group {{$errors->has('gambar') ? 'has-error' : null}}">
															<label for="gambar">Gambar Produk</label>
															<input type="file" class="form-control" id="gambar" name="gambar">
															<p class="text-danger">*Isi jika gambar ingin diganti</p>
															@if ($errors->has('gambar'))
																<span class="help-block text-danger">
																	{{$errors->first('gambar')}}
																</span>
															@endif
														</div>
													</div>
													<div class="col-md-3">
														<div class="image mr-3">
															@if ($menu->gambar != null)
																<img src="{{ asset('assets/img/daftar-menu/'.$menu->gambar) }}" class="w-100" alt="">
															@else
																<img src="{{ asset('assets/img/nf.png') }}" class="w-100" alt="">
															@endif
															
														</div>
													</div>
												</div>
												<div class="separator-solid"></div>
												<div class="text-center mt-3 mb-3">
													<input type="submit" name="update" value="Update" class="btn btn-success">
												</div>
											</div>
										</form>
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