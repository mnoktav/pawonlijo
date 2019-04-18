@extends('admin/booth-add')
@section('css')
	<style>
		.table th{
			text-transform: uppercase;
			font-weight: bold;
			margin-top: 1rem;
			font-size: 0.8rem;
		}
	</style>
@endsection
@section('step')
<form action="{{ route('admin.add-booth-save') }}" method="POST">	
	@csrf
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			<div class="row">
				<div class="col-md-12" style="padding: 1rem;">
					<h3><i class="fas fa-store text-warning"></i> &nbsp; <b>BOOTH</b></h3>
					<div class="separator-solid" style="border-color: #dddddd"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped border">
							<tr>
								<th width="25%">id booth</th>
								<td>{{ session('step1')['id_booth'] }}</td>
								<input type="hidden" name="id_booth" value="{{ session('step1')['id_booth'] }}">
							</tr>
							<tr>
								<th>nama Booth </th>
								<td>{{ session('step1')['nama_booth'] }}</td>
								<input type="hidden" name="nama_booth" value="{{ session('step1')['nama_booth'] }}">
							</tr>
							<tr>
								<th>alamat booth </th>
								<td>{{ session('step1')['alamat_booth'] }}</td>
								<input type="hidden" name="alamat_booth" value="{{ session('step1')['alamat_booth'] }}">
							</tr>
							<tr>
								<th>Kota</th>
								<td>{{ session('step1')['kota'] }}</td>
								<input type="hidden" name="kota" value="{{ session('step1')['kota'] }}">
							</tr>
							<tr>
								<th>Jam Operasional</th>
								<td>{{ session('step1')['jam_buka']." - ".session('step1')['jam_tutup'] }}</td>
								<input type="hidden" name="jam_buka" value="{{ session('step1')['jam_buka']}}">
								<input type="hidden" name="jam_tutup" value="{{session('step1')['jam_tutup'] }}">
							</tr>
							<tr>
								<th>Nomor Telepon</th>
								<td>{{ session('step1')['nomor'] }}</td>
								<input type="hidden" name="nomor" value="{{ session('step1')['nomor']}}">
							</tr>
							<tr>
								<th>username</th>
								<td>{{ session('step2')['username_booth'] }}</td>
								<input type="hidden" name="username_booth" value="{{ session('step2')['username_booth'] }}">
							</tr>
							<tr>
								<th>password</th>
								<td>{{ session('step2')['password_booth'] }}</td>
								<input type="hidden" name="password_booth" value="{{ session('step2')['password_booth'] }}">
							</tr>
						</table>
					</div>
				</div>
				<div class="col-md-12 mt--3" style="padding: 1rem;">
					<h3><i class="fas fa-chalkboard-teacher text-warning"></i> &nbsp; <b>KASIR</b></h3>
					<div class="separator-solid" style="border-color: #dddddd"></div>
					<div class="table-responsive">
						<table class="table table-bordered table-striped border">
							<tr>
								<th width="25%">nama kasir 1</th>
								<td>{{ session('step3')['nama_kasir1'] }}</td>
								<input type="hidden" name="nama_kasir[]" value="{{ session('step3')['nama_kasir1'] }}">
							</tr>
							<tr>
								<th>alamat kasir 1 </th>
								<td>{{ session('step3')['alamat_kasir1'] }}</td>
								<input type="hidden" name="alamat_kasir[]" value="{{ session('step3')['alamat_kasir1'] }}">
							</tr>
							<tr>
								<th>Nomor Telepon Kasir 1</th>
								<td>{{ session('step3')['no_kasir1'] }}</td>
								<input type="hidden" name="no_kasir[]" value="{{ session('step3')['no_kasir1'] }}">
							</tr>
							<tr>
								<th>nama kasir 2</th>
								<td>{{ session('step3')['nama_kasir2'] }}</td>
								<input type="hidden" name="nama_kasir[]" value="{{ session('step3')['nama_kasir2'] }}">
							</tr>
							<tr>
								<th>alamat kasir 2 </th>
								<td>{{ session('step3')['no_kasir2'] }}</td>
								<input type="hidden" name="no_kasir[]" value="{{ session('step3')['no_kasir2'] }}">
							</tr>
							<tr>
								<th>Nomor Telepon Kasir 2</th>
								<td>{{ session('step3')['alamat_kasir2'] }}</td>
								<input type="hidden" name="alamat_kasir[]" value="{{ session('step3')['alamat_kasir2'] }}">
							</tr>
						</table>
					</div>
				</div> 
			</div>
		</div>
		<div class="card-footer">
			<div class="text-center" style="margin: 0.5rem 0;">
				<a href="{{ route('admin.add-booth-step3') }}" class="btn btn-warning btn-rounded">Back</a>
				<input type="submit" name="finish" value="Save" class="btn btn-success btn-rounded">
			</div>
		</div>
	</div>
</form>
@endsection
