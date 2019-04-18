@extends('admin/master-d')
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Stok Menu PawonLijo</h4>
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
					<a>Stok Menu PawonLijo</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12 mb-1">
								<div class="form-group" style="padding: 0;">
									<div class="input-icon">
										<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
										<span class="input-icon-addon">
											<i class="fa fa-search"></i>
										</span>
									</div>
								</div>
								<div class="separator-solid"></div>
							</div>
							@foreach ($booths as $booth)
							<div class="col-md-3 target">
								<div class="card" style="border: 1px solid #dddddd">
									<div class="card-body">
										<div class="icon text-center">
											<i class="fas fa-store fa-3x text-danger"></i>
										</div>
										<div class="separator-solid"></div>
										<div class="nama-kota text-center">
											<h3 style="margin: 0;"><b>{{$booth->nama_booth}}</b></h3>
											<small>{{$booth->kota_booth}}</small>
										</div>
										<div class="separator-solid"></div>
										<div class="lihat-menu text-center">
											<a href="{{ route('admin.stock-product-booth', $booth->id_booth) }}" class="btn btn-primary btn-sm btn-rounded" style="padding: 0.4rem 1rem;">Lihat Stok Menu</a>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
