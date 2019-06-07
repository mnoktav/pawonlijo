@extends('admin/master-d')
@section('css')
	<style>
		.step label{
			text-transform: uppercase;
		}

		.step input, .step textarea{
			border: 1px solid #aaaaaa;
		}
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Tambah Booth Baru</h4>
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
					<a>Tambah Booth Baru</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10 offset-md-1">
								<ul class="nav nav-pills nav-primary nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.add-booth') ? 'active' : null}}">
											Booth
										</a>
									</li>
									<li class="nav-item">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.add-booth-step2') ? 'active' : null}}">
											Akun
										</a>
									</li>
									<li class="nav-item">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.add-booth-step3') ? 'active' : null}}">
											Kasir
										</a>
									</li>
									<li class="nav-item">
										<i class="flaticon-right-arrow"></i>
									</li>
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.add-booth-step4') || Route::is('admin.add-booth-step5') ? 'active' : null}}">
											Selesai
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="separator-dashed"></div>
						<div class="row">
							<div class="col-md-10 offset-md-1">
								@yield('step')
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	
@endsection