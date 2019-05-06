@extends('admin/booth-add')
@section('step')	
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			<h4><b>BOOOTH</b></h4>
			<div class="separator-dashed"></div>
			<form action="{{ route('admin.add-booth-save') }}" method="POST">
				@csrf
				<div class="form-group {{$errors->has('id_booth') ? 'has-error' : null}}">
					<label for="id-booth">ID Booth</label>
					<small class="text-muted ml-2"><i>(Ex: JBG1)</i></small>
					@if(session('step1') != null)
					<input type="text" class="form-control" id="id-booth" name="id_booth" value="{{ session('step1')['id_booth']}}" required="">
					@else
					<input type="text" class="form-control" id="id-booth" name="id_booth" value="{{old('id_booth')}}" required="">
					@endif
					@if ($errors->has('id_booth'))
						<span class="help-block text-danger">
							{{$errors->first('id_booth')}}
						</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('nama_booth') ? 'has-error' : null}}">
					<label for="nama-booth">Nama Booth</label>
					@if(session('step1') != null)
					<input type="text" class="form-control" id="nama-booth" name="nama_booth" value="{{ session('step1')['nama_booth'] }}" required="">
					@else
					<input type="text" class="form-control" id="nama-booth" name="nama_booth" value="{{old('nama_booth')}}" required="">
					@endif
					@if ($errors->has('nama_booth'))
						<span class="help-block text-danger">
							{{$errors->first('nama_booth')}}
						</span>
					@endif
				</div>
				<div class="form-group">
					<label for="alamat-booth">Alamat Booth</label>
					@if(session('step1') != null)
					<textarea class="form-control" id="alamat-booth" name="alamat_booth">{{ session('step1')['alamat_booth'] }}</textarea>
					@else
					<textarea class="form-control" id="alamat-booth" name="alamat_booth">{{old('alamat_booth')}}</textarea>
					@endif
				</div>
				<div class="form-group">
					<label for="kota">Kota</label>
					@if(session('step1') != null)
					<input type="text" class="form-control" id="kota" name="kota" value="{{ session('step1')['kota'] }}" required="">
					@else
					<input type="text" class="form-control" id="kota" name="kota" value="{{old('kota')}}" required="">
					@endif
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="jam-buka">Jam Buka</label>
							@if(session('step1') != null)
							<input type="time" class="form-control" id="jam-buka" name="jam_buka" value="{{ session('step1')['jam_buka'] }}" required="">
							@else
							<input type="time" class="form-control" id="jam-buka" name="jam_buka" value="{{old('jam_buka')}}" required="">
							@endif
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="jam-tutup">Jam Tutup</label>
							@if(session('step1') != null)
							<input type="time" class="form-control" id="jam-tutup" name="jam_tutup" value="{{ session('step1')['jam_tutup'] }}" required="">
							@else
							<input type="time" class="form-control" id="jam-tutup" name="jam_tutup" value="{{old('jam_tutup')}}" required="">
							@endif
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="nomor">Nomor Telephone</label>
					@if(session('step1') != null)
					<input type="text" class="form-control" id="nomor" name="nomor" value="{{ session('step1')['nomor'] }}" onkeypress="return NumberOnly()">
					@else
					<input type="text" class="form-control" id="nomor" name="nomor" value="{{old('nomor')}}" onkeypress="return NumberOnly(event)">
					@endif
				</div>
				<div class="text-center" style="margin: 1rem 0;">
					<input type="submit" name="step1" value="Next" class="btn btn-success btn-rounded">
				</div>
			</form>
		</div>
	</div>
@endsection
