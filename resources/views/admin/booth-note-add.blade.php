@extends('admin/master-d')
@section('css')
	<style>
		.add-booth input, .add-booth textarea{
			border: 1px solid #aaaaaa;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Note Booth PawonLijo</h4>
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
					<a>Booth</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Note Booth PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Tambah Note</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body add-booth">
						<div class="row">
							<div class="col-md-6 offset-md-2">
								<h4><i class="fas fa-sticky-note text-warning"></i> &nbsp;<b>TAMBAH NOTE BARU</b></h4>
							</div>
							<div class="col-md-2 text-right" style="padding: 0;">
								<a class="btn btn-sm btn-rounded btn-primary mr-4" href="{{ route('admin.note-booth') }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
							<div class="col-md-12">
								<div class="separator-solid"></div>
							</div>
							<div class="col-md-8 offset-md-2 add-booth">
								<form action="{{ route('admin.save-note') }}" method="POST">
									@csrf
							        <div class="form-group {{$errors->has('id_booth') ? 'has-error' : null}}">
										<label for="booth">Booth :</label>
										<div class="selectgroup selectgroup-pills ml-3 mt--3">
											@foreach ($booths as $booth)
												<label class="selectgroup-item mt-1">
													<input type="checkbox" name="id_booth[]" value="{{$booth->id_booth}}" class="selectgroup-input">
													<span class="selectgroup-button">{{$booth->nama_booth.', '.$booth->kota_booth}}</span>
												</label>
											@endforeach
										</div>
										<br>
										@if ($errors->has('id_booth'))
											<span class="help-block text-danger">
												{{$errors->first('id_booth')}}
											</span>
										@endif
									</div>
									<div class="form-group {{$errors->has('judul') ? 'has-error' : null}}">
										<label for="pesan">Judul :</label>
										<input type="text" class="form-control" name="judul" value="{{old('judul')}}">
										@if ($errors->has('judul'))
											<span class="help-block text-danger">
												{{$errors->first('judul')}}
											</span>
										@endif
									</div>
									<div class="form-group">
										<label for="pesan">Pesan :</label>
										<textarea class="form-control" id="pesan" cols="30" rows="10" name="pesan">{{old('pesan')}}</textarea>
									</div>
									<div class="text-right mr-2 mt-4">
										<button type="button" class="btn btn-danger btn-rounded" data-dismiss="modal">Reset</button> &nbsp;
						        		<input type="submit" value="Simpan" name="save" class="btn btn-primary btn-rounded">
									</div>
						      	</form>
					      	</div>
				      	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

