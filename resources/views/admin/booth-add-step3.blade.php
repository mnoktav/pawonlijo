@extends('admin/booth-add')
@section('step')	
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			<form action="{{ route('admin.add-booth-save') }}" method="POST">
				@csrf
				<div class="form-group">
					<label for="nama-kasir1">Nama Kasir 1</label>
					<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir1" value="{{ session('step3')['nama_kasir1'] }}">
				</div>
				<div class="form-group">
					<label for="alamat-kasir1">Alamat Kasir 1</label>
					<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir1">{{ session('step3')['alamat_kasir1']}}</textarea>
				</div>
				<div class="form-group">
					<label for="no-kasir1">Telephone Kasir 1</label>
					<input type="text" class="form-control" id="no-kasir1" name="no_kasir1" value="{{ session('step3')['no_kasir1']}}">
				</div>
				<div class="separator-solid"></div>
				<div class="form-group">
					<label for="nama-kasir2">Nama Kasir 2</label>
					<input type="text" class="form-control" id="nama-kasir2" name="nama_kasir2" value=" {{ session('step3')['nama_kasir2'] }}">
				</div>
				<div class="form-group">
					<label for="alamat-kasir2">Alamat Kasir 2</label>
					<textarea class="form-control" id="alamat-kasir2" name="alamat_kasir2">{{ session('step3')['alamat_kasir2'] }}</textarea>
				</div>
				<div class="form-group">
					<label for="no-kasir2">Telephone Kasir 2</label>
					<input type="text" class="form-control" id="no-kasir2" name="no_kasir2" value="{{ session('step3')['no_kasir2']}}">
				</div>
				<div class="text-center" style="margin: 1rem 0;">
					<a href="{{ route('admin.add-booth-step2') }}" class="btn btn-warning btn-rounded">Back</a>
					<input type="submit" name="step3" value="Next" class="btn btn-success btn-rounded">
				</div>
			</form>
		</div>
	</div>
@endsection
