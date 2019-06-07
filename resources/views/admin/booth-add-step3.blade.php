@extends('admin/booth-add')
@section('step')	
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			
			<form action="{{ route('admin.add-booth-save') }}" method="POST">
				@csrf

				@if (session('step3') != null)
					<button class="btn btn-primary btn-sm add_field ml-2 mb-2"><i class="fas fa-plus"></i></button>
					@for ($i = 0; $i < count(session('step3')) ; $i++)
					<div class="pegawai-form">
						<div class="form-group">
							<label for="nama-kasir1">Nama Kasir</label>
							<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]" value="{{session('step3')[$i]['nama_kasir']}}" required="">
						</div>
						<div class="form-group">
							<label for="alamat-kasir1">Alamat Kasir</label>
							<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]" required="">{{session('step3')[$i]['alamat_kasir']}}</textarea>
						</div>
						<div class="form-group">
							<label for="no-kasir1">Telephone Kasir</label>
							<input type="text" class="form-control" id="no-kasir1" name="no_kasir[]" value="{{session('step3')[$i]['no_kasir']}}" onkeypress="return NumberOnly(event)" required="">
						</div>
						<div class="separator-solid"></div>
					</div>
					@endfor
				@else
					<button class="btn btn-primary btn-sm add_field ml-2 mb-2"><i class="fas fa-plus"></i></button>
					<div class="pegawai-form">
						<div class="form-group">
							<label for="nama-kasir1">Nama Kasir</label>
							<input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]" value="" required="">
						</div>
						<div class="form-group">
							<label for="alamat-kasir1">Alamat Kasir</label>
							<textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]" required=""></textarea>
						</div>
						<div class="form-group">
							<label for="no-kasir1">Telephone Kasir</label>
							<input type="text" class="form-control" id="no-kasir1" name="no_kasir[]" value="" onkeypress="return NumberOnly(event)" required="">
						</div>
						<div class="separator-solid"></div>
					</div>
				@endif
				{{-- <div class="form-group">
					<label for="nama-kasir2">Nama Kasir 2</label>
					<input type="text" class="form-control" id="nama-kasir2" name="nama_kasir2" value=" {{ session('step3')['nama_kasir2'] }}">
				</div>
				<div class="form-group">
					<label for="alamat-kasir2">Alamat Kasir 2</label>
					<textarea class="form-control" id="alamat-kasir2" name="alamat_kasir2">{{ session('step3')['alamat_kasir2'] }}</textarea>
				</div>
				<div class="form-group">
					<label for="no-kasir2">Telephone Kasir 2</label>
					<input type="text" class="form-control" id="no-kasir2" name="no_kasir2" value="{{ session('step3')['no_kasir2']}}" onkeypress="return NumberOnly(event)">
				</div>--}}
				<div class="text-center" style="margin: 1rem 0;">
					<a href="{{ route('admin.add-booth-step2') }}" class="btn btn-warning btn-rounded">Back</a>
					<input type="submit" name="step3" value="Next" class="btn btn-success btn-rounded">
				</div> 
			</form>
		</div>
	</div>
@endsection
@section('js')
	<script>
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper   		= $(".pegawai-form"); //Fields wrapper
		var add_button      = $(".add_field"); //Add button ID
		
		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div><div class="form-group"><label for="nama-kasir1">Nama Kasir </label> <input type="text" class="form-control" id="nama-kasir1" name="nama_kasir[]" value=""></div><div class="form-group"><label for="alamat-kasir1">Alamat Kasir </label><textarea class="form-control" id="alamat-kasir1" name="alamat_kasir[]"></textarea></div><div class="form-group"><label for="no-kasir1">Telephone Kasir </label><input type="text" class="form-control" id="no-kasir1" name="no_kasir[]" value="" onkeypress="return NumberOnly(event)"></div><a href="#" class="remove_field ml-2 btn btn-sm btn-danger">Remove</a><div class="separator-solid"></div></div>'); //add input box
			}
		});
		
		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent('div').remove(); x--;
		})
	</script>
@endsection