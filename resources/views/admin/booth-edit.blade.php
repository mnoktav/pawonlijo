@extends('admin/master-d')
@section('css')
	<style>
		.form .form-group{
			margin: 1.2rem 0;
			padding: 0;
		}
		.form label{
			text-transform: uppercase;
		}
		.form input, .form textarea{
			border: 1px solid #aaaaaa;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Booth PawonLijo</h4>
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
					<a>Booth PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Edit</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<h4><b>{{$booth->nama_booth}}, {{$booth->kota_booth}}</b></h4>
								<small class="text-secondary"><b>#PLJBG1</b></small>
							</div>
							<div class="col-lg-6 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.detail-booth',$booth->id_booth) }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<ul class="nav nav-pills nav-primary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-home-tab-nobd" data-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Booth</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-akun-tab-nobd" data-toggle="pill" href="#pills-akun-nobd" role="tab" aria-controls="pills-akun-nobd" aria-selected="false">Akun</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-kasir-tab-nobd" data-toggle="pill" href="#pills-kasir-nobd" role="tab" aria-controls="pills-kasir-nobd" aria-selected="false">Kasir</a>
							</li>
						</ul>
						<div class="row" style="margin-top: 1rem;">
							<div class="col-md-12">
								<div class="tab-content" id="pills-without-border-tabContent">
									<div class="tab-pane fade show active" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
										<div class="card" style="border: 1px solid #dddddd;">
											<div class="card-body">
												<form action="{{ route('admin.update-booth') }}" method="POST">
													@csrf
													<h4><b><span class="fas fa-info-circle text-warning"></span>&nbsp; INFORMASI BOOTH</b></h4>
													<div class="separator-solid"></div>
													<div class="form col-md-8 col-12" style="padding: 0;">
														<div class="form-group">
															<label for="id-booth">ID Booth</label>
															<input type="text" class="form-control" id="id_booth" value="{{$booth->id_booth}}" name="id_booth" readonly="">
														</div>
														<div class="form-group">
															<label for="nama-booth">Nama Booth</label>
															<input type="text" class="form-control" id="nama_booth" name="nama_booth" value="{{$booth->nama_booth}}" readonly="">
														</div>
														<div class="form-group">
															<label for="alamat-booth">Alamat Booth</label>
															<textarea class="form-control" name="alamat_booth" id="alamat_booth">{{$booth->alamat_booth}}</textarea>
														</div>
														<div class="form-group">
															<label for="kota">Kota</label>
															<input type="text" class="form-control" name="kota" id="kota" value="{{$booth->kota_booth}}">
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="jam_buka">Jam Buka</label>
																	<input type="time" class="form-control" name="jam_buka" id="jam_buka" value="{{$booth->jam_buka}}">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="jam_tutup">Jam Tutup</label>
																	<input type="time" class="form-control" name="jam_tutup" id="jam_tutup" value="{{$booth->jam_tutup}}">
																</div>
															</div>
														</div>
														<div class="form-group">
															<label for="nomor">Nomor Telephone</label>
															<input type="text" class="form-control" name="nomor" id="nomor" value="{{$booth->telepon_booth}}">
														</div>
														<div class="text-right">
															<input type="submit" name="update_booth" value="Update" class="btn btn-warning">
														</div>	
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="pills-akun-nobd" role="tabpanel" aria-labelledby="pills-akun-tab-nobd">
										<div class="card" style="border: 1px solid #dddddd;">
											<div class="card-body">
												<h4><b><span class="fas fa-user-lock text-warning"></span>&nbsp; AKUN</b></h4>
												<div class="separator-solid"></div>
												<div class="form col-md-8 col-12" style="padding: 0;">
													<div class="form-group">
														<label for="username">username</label>
														<input type="text" class="form-control" id="username" disabled="" value="{{$booth->username_booth}}">

													</div>
													<div class="row">
														<div class="col-md-10">
															<div class="form-group">
																<label>Password</label>
																<input type="password" class="form-control" value="{{Crypt::decryptString($booth->password_booth)}}" readonly="" id="password">
															</div>
														</div>
														<div class="col-md-1 mt-4 pt-2">
															<div class="form-group">
																<button class="btn btn-sm btn-primary btn-rounded" onclick="LihatPassword()">Lihat</button>
															</div>
														</div>
													</div>
												</div>
												<br>
												<h4><b><span class="fas fa-user-edit text-warning"></span>&nbsp; UPDATE AKUN</b></h4>
												<div class="separator-solid"></div>
												<div class="form col-md-8 col-12" style="padding: 0;">
													<form action="{{ route('admin.update-booth') }}" method="POST">
														@csrf
														<div class="form-group {{$errors->has('username_booth') ? 'has-error' : null}}">
															<label for="username">username</label>
															<input type="text" class="form-control" id="username_booth" name="username_booth" value="{{$booth->username_booth}}">
															<input type="hidden" name="id_booth" value="{{$booth->id_booth}}">
															@if ($errors->has('username_booth'))
																<span class="help-block text-danger">
																	{{$errors->first('username_booth')}}
																</span>
															@endif
														</div>
														<div class="form-group {{$errors->has('password_booth') ? 'has-error' : null}}">
															<label for="password_booth">Password Baru</label>
															<input type="password" class="form-control" id="password_booth" name="password_booth">
															@if ($errors->has('password_booth'))
																<span class="help-block text-danger">
																	{{$errors->first('password_booth')}}
																</span>
															@endif
														</div>
														<div class="form-group {{$errors->has('re_pass') ? 'has-error' : null}}">
															<label for="repass">Ketik Ulang Password Baru</label>
															<input type="password" class="form-control" id="re_pass" name="repass">
															@if ($errors->has('re_pass'))
																<span class="help-block text-danger">
																	{{$errors->first('re_pass')}}
																</span>
															@endif
														</div>
														<div class="text-right">
															<input type="submit" value="Update" name="update_akun" class="btn btn-warning">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="pills-kasir-nobd" role="tabpanel" aria-labelledby="pills-kasir-tab-nobd">
										<div class="card" style="border: 1px solid #dddddd;">
											<div class="card-body">
												<h4><b><span class="fas fa-info-circle text-warning"></span>&nbsp; INFORMASI BOOTH</b></h4>
												<div class="separator-solid"></div>
												@if ($jumlah_kasir < 1)
												<form action="{{ route('admin.update-booth') }}" method="POST">
													@csrf
													<div class="form col-md-8 col-12" style="padding: 0;">
														<div class="form-group">
															<label for="nama-kasir1">Nama Kasir 1</label>
															<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]">
															<input type="hidden" name="id_kasir[]" value="{{$max}}">
															<input type="hidden" name="id_booth[]" value="{{$booth->id_booth}}">
														</div>
														<div class="form-group">
															<label for="alamat-kasir1">Alamat Kasir 1</label>
															<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]"></textarea>
														</div>
														<div class="form-group">
															<label for="no-kasir1">Telephone Kasir 1</label>
															<input type="text" class="form-control" id="no-kasir1" name="telp_kasir[]">
														</div>
														<div class="form-group">
															<label for="nama-kasir2">Nama Kasir 2</label>
															<input type="text" class="form-control" id="nama-kasir2" name="nama_kasir[]">
															<input type="hidden" name="id_kasir[]" value="{{$max+1}}">
															<input type="hidden" name="id_booth[]" value="{{$booth->id_booth}}">
														</div>
														<div class="form-group">
															<label for="alamat-kasir2">Alamat Kasir 2</label>
															<textarea class="form-control" id="alamat-kasir2" name="alamat_kasir[]"></textarea>
														</div>
														<div class="form-group">
															<label for="no-kasir2">Telephone Kasir 2</label>
															<input type="text" class="form-control" id="no-kasir2" name="telp_kasir[]">
														</div>
														<div class="text-right">
															<input type="submit" name="update_kasir1" value="Update" class="btn btn-warning">
														</div>
													</div>
												</form>
												@elseif($jumlah_kasir == 1)
												<form action="{{ route('admin.update-booth') }}" method="POST">
													@csrf
													<div class="form col-md-8 col-12" style="padding: 0;">
														@foreach ($kasirs as $kasir)
															<div class="form-group">
																<label for="nama-kasir1">Nama Kasir 1</label>
																<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]" value="{{$kasir->nama_kasir}}">
																<input type="hidden" name="id_kasir[]" value="{{$kasir->id}}">
																<input type="hidden" name="id_booth[]" value="{{$booth->id_booth}}">
															</div>
															<div class="form-group">
																<label for="alamat-kasir1">Alamat Kasir 1</label>
																<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]">{{$kasir->alamat_kasir}}</textarea>
															</div>
															<div class="form-group">
																<label for="no-kasir1">Telephone Kasir 1</label>
																<input type="text" class="form-control" id="no-kasir1" name="telp_kasir[]" value="{{$kasir->telp_kasir}}">
															</div>
															<a href="{{ route('admin.delete-kasir',$kasir->id) }}" class="btn btn-danger btn-sm hapus-kasir" data-id="{{$kasir->id}}">Hapus</a>
															<div class="separator-solid"></div>
														@endforeach
														<div class="form-group">
															<label for="nama-kasir2">Nama Kasir 2</label>
															<input type="text" class="form-control" id="nama-kasir2" name="nama_kasir[]">
															<input type="hidden" name="id_booth[]" value="{{$booth->id_booth}}">
															<input type="hidden" name="id_kasir[]" value="{{$max}}">

														</div>
														<div class="form-group">
															<label for="alamat-kasir2">Alamat Kasir 2</label>
															<textarea class="form-control" id="alamat-kasir2" name="alamat_kasir[]"></textarea>
														</div>
														<div class="form-group">
															<label for="no-kasir2">Telephone Kasir 2</label>
															<input type="text" class="form-control" id="no-kasir2" name="telp_kasir[]">
														</div>
														<div class="text-right">
															<input type="submit" name="update_kasir1" value="Update" class="btn btn-warning">
														</div>
													</div>
												</form>
											
												@elseif($jumlah_kasir == 2)
												<form action="{{ route('admin.update-booth') }}" method="POST">
													@csrf
													<div class="form col-md-8 col-12" style="padding: 0;">
														@foreach ($kasirs as $kasir)
															<div class="form-group">
																<label for="nama-kasir1">Nama Kasir</label>
																<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]" value="{{$kasir->nama_kasir}}">
																<input type="hidden" name="id_kasir[]" value="{{$kasir->id}}">
																<input type="hidden" name="id_booth[]" value="{{$booth->id_booth}}">
																
															</div>
															<div class="form-group">
																<label for="alamat-kasir1">Alamat Kasir</label>
																<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]">{{$kasir->alamat_kasir}}</textarea>
															</div>
															<div class="form-group">
																<label for="no-kasir1">Telephone Kasir</label>
																<input type="text" class="form-control" id="no-kasir1" name="telp_kasir[]" value="{{$kasir->telp_kasir}}">
															</div>
															<a href="{{ route('admin.delete-kasir',$kasir->id) }}" class="btn btn-danger btn-sm hapus-kasir" data-id="{{$kasir->id}}">Hapus</a>
															<div class="separator-solid"></div>
														@endforeach
														<div class="text-right">
															<input type="submit" name="update_kasir1" value="Update" class="btn btn-warning">
														</div>
													</div>

												</form>
												@endif
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
		function LihatPassword() {
		  	var x = document.getElementById("password");
		  	if (x.type === "password") {
		    	x.type = "text";
			 } else {
			    x.type = "password";
			}
		}
	</script>
	<script>
		$(document).ready(function(){
		    $('.hapus-kasir').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin?",
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