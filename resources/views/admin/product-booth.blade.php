@extends('admin/product')
@section('booth-product')	
	<div class="row">
		@foreach ($booths as $booth)
		<div class="col-md-3 target">
			<div class="card" style="border: 1px solid #dddddd">
				<div class="card-body">
					<div class="icon text-center">
						<i class="fas fa-store fa-3x text-danger"></i>
					</div>
					<div class="separator-solid"></div>
					<div class="nama-kota text-center">
						<h3 style="margin: 0; text-transform: capitalize;"><b>{{$booth->nama_booth}}</b></h3>
						<small style="text-transform: capitalize;">{{$booth->kota_booth}}</small>
					</div>
					<div class="separator-solid"></div>
					<div class="lihat-menu text-center">
						<a href="{{ route('admin.product-booth-menu', $booth->id_booth) }}" class="btn btn-primary  btn-rounded" style="padding: 0.4rem 1rem;">Lihat Menu</a>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>
@endsection

