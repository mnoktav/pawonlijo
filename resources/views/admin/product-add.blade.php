@extends('admin/product')
@section('css')
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<style>
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
							<input type="text" class="form-control" id="tags" name="nama_makanan" value="{{old('nama_makanan')}}">
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
								<option value="minuman">Minuman</option>
							</select>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group {{$errors->has('harga') ? 'has-error' : null}}">
									<label for="harga">Jenis Transaksi</label>
									@if ($errors->has('harga'))
										<span class="help-block text-danger">
											{{$errors->first('harga')}}
										</span>
									@endif
								</div>
							</div>
							@foreach ($j as $jenis)
								<div class="col-md-3 mt--4">
									<div class="form-group">
										<small style="text-transform: uppercase;">{{$jenis->jenis_transaksi}}</small>
										<input type="text" class="form-control" name="harga[]" onkeypress="return NumberOnly(event)" placeholder="Rp ...">
									</div>
								</div>
							@endforeach
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
@section('js')
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script>
	  $( function() {
	    var availableTags = 
	 	{!!json_encode($p)!!};
	    
	    $( "#tags" ).autocomplete({
	      source: availableTags
	    });
	  } );
  	</script>
  	
@endsection