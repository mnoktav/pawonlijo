@extends('admin/master-d')
@section('css')
	<style>
	.table th, .table td{
		border: none;
		height: 2.5rem !important;
		padding-top: 1rem !important;
	}
	.form-control{
		border: 1px solid #aaaaaa;
	}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Admin Pawon Lijo</h4>
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
					<a>Admin</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Akun</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 mb-3 text-right">
				TERAKHIR UPDATE : {{date('j/n/Y H:i', strtotime($user->updated_at))}}
			</div>
			<div class="col-md-6">
				<div class="card border full-height">
					<div class="card-body">
						<h4><b>AKUN</b></h4>
						<div class="separator-solid"></div>
						<form action="{{ route('admin.akun-update') }}" method="POST">
						@csrf
						<input type="hidden" value="{{$user->id}}" name="id">
							<table class="table">
								<tr>
									<th width="20%">Username</th>
									<td width="2%">:</td>
									<td>
										<div class="form-group p-0 {{$errors->has('username') ? 'has-error' : null}}">
											<input type="text" class="form-control" name="username" id="username" value="{{$user->username}}" required="">
											@if ($errors->has('username'))
			                                    <span class="help-block text-danger mt-1">
			                                        {{$errors->first('username')}}
			                                    </span>
			                                @endif
										</div>
									</td>
								</tr>
								<tr>
									<th>E-mail</th>
									<td>:</td>
									<td>
										<div class="form-group p-0 {{$errors->has('email') ? 'has-error' : null}}">
											<input type="email" class="form-control" name="email" id="email" value="{{$user->email}}" required="">
											@if ($errors->has('email'))
			                                    <span class="help-block text-danger mt-1">
			                                        {{$errors->first('email')}}
			                                    </span>
			                                @endif
										</div>
									</td>
								</tr>
								<tr>
									<th>Password</th>
									<td>:</td>
									<td><input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password" required=""></td>
								</tr>
							</table>
							<div class="text-right pr-4">
								<input type="submit" class="btn btn-warning" value="Update" name="update">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card border full-height">
					<div class="card-body">
						<h4><b>PASSWORD</b></h4>
						<div class="separator-solid"></div>
						<form action="{{ route('admin.akun-update') }}" method="POST">
						@csrf
						<input type="hidden" value="{{$user->id}}" name="id_u">
							<table class="table">
								<tr>
									<th width="20%">Password Baru</th>
									<td width="2%">:</td>
									<td>
										<div class="form-group p-0 {{$errors->has('password_baru') ? 'has-error' : null}}">
											<input type="password" class="form-control" name="password_baru" id="password_baru" placeholder="Password Baru" required="">
											@if ($errors->has('password_baru'))
			                                    <span class="help-block text-danger mt-1">
			                                        {{$errors->first('password_baru')}}
			                                    </span>
			                                @endif
										</div>
									</td>
								</tr>
								<tr>
									<th>Re-Type</th>
									<td>:</td>
									<td>
										<div class="form-group p-0 {{$errors->has('retype') ? 'has-error' : null}}">
											<input type="password" class="form-control" name="retype" id="retype" placeholder="Ketik Ulang Password Baru" required="">
											@if ($errors->has('retype'))
			                                    <span class="help-block text-danger mt-1">
			                                        {{$errors->first('retype')}}
			                                    </span>
			                                @endif
										</div>
									</td>
								</tr>
								<tr>
									<th>Password</th>
									<td>:</td>
									<td>
										<input type="password" class="form-control" name="password_l" id="password_l" placeholder="Masukkan Password" required="">
									</td>
								</tr>
							</table>
							<div class="text-right pr-4">
								<input type="submit" class="btn btn-warning" value="Update Password" name="update_p">
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
		$(document).ready(function() {
		  $(window).keydown(function(event){
		    if(event.keyCode == 13) {
		      event.preventDefault();
		      return false;
		    }
		  });
		});
	</script>
@endsection
