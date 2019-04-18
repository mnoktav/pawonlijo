@extends('admin/master-d')
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Daftar Menu PawonLijo</h4>
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
					<a>Daftar Menu</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.product') ? 'active' : null}}" href="{{ route('admin.product') }}"><i class="fas fa-store"></i></a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.product-stats') ? 'active' : null}}" href="{{ route('admin.product-stats') }}"><i class="fas fa-chart-bar"></i></a>
									</li>
									<li class="nav-item">
										<a class="nav-link {{Route::is('admin.product-add') ? 'active' : null}}" href="{{ route('admin.product-add') }}"><i class="fas fa-plus"></i></a>
									</li>
								</ul>							
							</div>
							<div class="col-md-4 mt-1 {{Route::is('admin.product-stats') ? 'd-none' : null}}{{Route::is('admin.product-add') ? 'd-none' : null}}">
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
						<div class="separator-solid"></div>
						@yield('booth-product')
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script>
		function Search() {
		  var input = document.getElementById("search");
		  var filter = input.value.toLowerCase();
		  var nodes = document.getElementsByClassName('target');

		  for (i = 0; i < nodes.length; i++) {
		    if (nodes[i].innerText.toLowerCase().includes(filter)) {
		      nodes[i].style.display = "block";
		    } else {
		      nodes[i].style.display = "none";
		    }
		  }
		}
	</script>
@endsection
