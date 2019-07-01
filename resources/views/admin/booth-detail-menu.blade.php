@extends('admin/booth-detail')
@section('content2')	
	{{-- daftar menu --}}
	<div class="card" style="border: 1px solid #dddddd;">
		<div class="card-body">
			<h4><b><span class="fas fa-clipboard-list text-warning"></span>&nbsp; DAFTAR MENU</b></h4>
			<div class="separator-solid"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" style="padding: 0;">
						<div class="input-icon">
							<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
							<span class="input-icon-addon">
								<i class="fa fa-search"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-3 target">
					<div class="shadow-none card card-pricing" style="border: 1px solid #dddddd">
						<div class="card-header" style="padding-top: 0;">
							<div class="card-img" style="margin-bottom: 0.5rem;"> 
								<img src="{{ asset('assets/img/daftar-menu/izza.png') }}" alt="" class="w-100">
							</div>
							<h4 class="card-title"><b>Pizza</b></h4>
						</div>
						<div class="card-body" style="padding-top: 0; padding-bottom: 0;">
							<ul class="specification-list" style="padding-top: 0; padding-bottom: 0;">
								<li>
									<span class="name-specification">Reguler</span>
									<span class="status-specification"><b>Rp 20.000</b></span>
								</li>
								<li>
									<span class="name-specification">Go-food</span>
									<span class="status-specification"><b>Rp 20.000</b></span>
								</li>
								<li>
									<span class="name-specification">Grab</span>
									<span class="status-specification"><b>Rp 20.000</b></span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- end daftar menu --}}
@endsection
