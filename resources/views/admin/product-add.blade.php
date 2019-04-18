@extends('admin/product')
@section('css')
	<style>
		.form-group{
			padding: 1rem 0;
		}
		.form-group label{
			text-transform: uppercase;
		}
		.form-group input, .form-group select, .tambah-produk{
			border: 1px solid #cccccc;
		}
	</style>
@endsection
@section('booth-product')
	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="card tambah-produk">
				<div class="card-body">
					<form action="{{ route('admin.product-save') }}" method="POST" enctype="multipart/form-data">
						@csrf
						<h4><i class="fas fa-tag mr-2 text-warning"></i><b>TAMBAH PRODUK</b></h4>
						<div class="separator-solid"></div>
						<div class="form-group {{$errors->has('nama_makanan') ? 'has-error' : null}}">
							<label for="nama_makanan">Nama Makanan</label>
							<input type="text" class="form-control" id="nama_makanan" name="nama_makanan" value="{{old('nama_makanan')}}">
							@if ($errors->has('nama_makanan'))
								<span class="help-block text-danger">
									{{$errors->first('nama_makanan')}}
								</span>
							@endif
						</div>
						<div class="form-group">
							<label for="kategori">Kategori</label>
							<select name="kategori" id="kategori" class="form-control" name="kategori">
								<option value="makanan">Makanan</option>
								<option value="makanan">Minuman</option>
							</select>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group {{$errors->has('reguler') ? 'has-error' : null}}">
									<label for="reguler">Harga Reguler</label>
									<input type="text" class="form-control" id="reguler" name="reguler" value="{{old('reguler')}}">
									@if ($errors->has('reguler'))
										<span class="help-block text-danger">
											{{$errors->first('reguler')}}
										</span>
									@endif
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group {{$errors->has('gojek') ? 'has-error' : null}}">
									<label for="reguler">Harga Go-Food</label>
									<input type="text" class="form-control" id="gojek" name="gojek" value="{{old('gojek')}}">
									@if ($errors->has('gojek'))
										<span class="help-block text-danger">
											{{$errors->first('gojek')}}
										</span>
									@endif
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group {{$errors->has('grab') ? 'has-error' : null}}">
									<label for="reguler">Harga Grab</label>
									<input type="text" class="form-control" id="grab" name="grab" value="{{old('grab')}}">
									@if ($errors->has('grab'))
										<span class="help-block text-danger">
											{{$errors->first('grab')}}
										</span>
									@endif
								</div>
							</div>
						</div>
						<div class="form-group {{$errors->has('gambar') ? 'has-error' : null}}">
							<label for="gambar">Gambar Produk</label>
							<input type="file" class="form-control" id="gambar" name="gambar">
							@if ($errors->has('gambar'))
								<span class="help-block text-danger">
									{{$errors->first('gambar')}}
								</span>
							@endif
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group {{$errors->has('id_booth') ? 'has-error' : null}}">
									<label>Booth</label>
									@if ($errors->has('id_booth'))
										<span class="help-block text-danger ml-4">
											{{$errors->first('id_booth')}}
										</span>
									@endif
								</div>
							</div>
							<div class="selectgroup selectgroup-pills ml-3 mt--3">
								@foreach ($booths as $booth)
								<label class="selectgroup-item mt-1">
									<input type="checkbox" name="id_booth[]" value="{{$booth->id_booth}}" class="selectgroup-input">
									<span class="selectgroup-button">{{$booth->nama_booth.', '.$booth->kota_booth}}</span>
								</label>
								@endforeach
							</div>
						</div>
						<div class="separator-solid mt-4 mb-3"></div>
						<div class="text-center">
							<input type="submit" value="Simpan" name="simpan" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection