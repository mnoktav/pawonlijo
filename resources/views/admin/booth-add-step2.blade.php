@extends('admin/booth-add')
@section('step')	
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			<form action="{{ route('admin.add-booth-save') }}" method="POST">
				@csrf
				<div class="form-group {{$errors->has('username_booth') ? 'has-error' : null}}">					
					<label for="username_booth">Username</label>
					@if(session('step3') != null)
					<input type="text" class="form-control" id="username_booth" name="username_booth" value="{{ session('step2')['username_booth']}}">
					@else
					<input type="text" class="form-control" id="username_booth" name="username_booth" value="{{old('username_booth')}}">
					@endif
					@if ($errors->has('username_booth'))
						<span class="help-block text-danger">
							{{$errors->first('username_booth')}}
						</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('password_booth') ? 'has-error' : null}}" >
					<label for="password_booth">Password</label>
					@if(session('step3') != null)
					<input type="password" class="form-control" id="password_booth" name="password_booth" value="{{ session('step2')['password_booth']}}">
					@else
					<input type="password" class="form-control" id="password_booth" name="password_booth" value="{{old('password_booth')}}">
					@endif
					@if ($errors->has('password_booth'))
						<span class="help-block text-danger">
							{{$errors->first('password_booth')}}
						</span>
					@endif
				</div>
				<div class="form-group {{$errors->has('re_pass') ? 'has-error' : null}}">
					<label for="re_pass">Ketik Ulang Password</label>
					@if(session('step3') != null)
					<input type="password" class="form-control" id="re_pass" name="re_pass" value="{{ session('step2')['re_pass']}}">
					@else
					<input type="password" class="form-control" id="re_pass" name="re_pass" value="{{ old('re_pass')}}">
					@endif
					@if ($errors->has('re_pass'))
						<span class="help-block text-danger">
							{{$errors->first('re_pass')}}
						</span>
					@endif
				</div>
				<div class="text-center" style="margin: 1rem 0;">
					<a href="{{ route('admin.add-booth') }}" class="btn btn-warning btn-rounded">Back</a>
					<input type="submit" name="step2" value="Next" class="btn btn-success btn-rounded">
				</div>
			</form>
		</div>
	</div>
@endsection
