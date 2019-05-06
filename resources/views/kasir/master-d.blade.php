{{Request::segment(2) == 'transaksi' && Request::segment(2) == 'stok' ? session()->forget('cart') : null}}
{{StatusBooth(session('login')['id_booth'])}}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Kasir PawonLijo</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="../assets/img/icon.ico" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="{{ asset('assets/atlantis/js/plugin/webfont/webfont.min.js') }}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/atlantis/css/fonts.min.css') }}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="{{ asset('assets/atlantis/css/bootstrap.min.css') }} ">
	<link rel="stylesheet" href="{{ asset('assets/atlantis/css/atlantis.min.css') }} ">
	@yield('css')
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="orange2">
				
				<a href="index.html" class="logo">
					<img src="{{ asset('assets/atlantis/img/logo.svg') }}" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="orange">
				
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						{{-- <li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li> --}}
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ asset('assets/img/user.png') }}" alt="..." class="avatar-img rounded-circle">
								</div> 
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{ asset('assets/img/user.png') }}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{session('login')['nama_booth']}}</h4>
												<p class="text-muted">{{session('login')['username_booth']}}</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{ route('kasir.logout') }}">Logout</a>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img src="{{ asset('assets/img/user.png') }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{session('login')['nama_booth']}}
									<span class="user-level">{{session('login')['username_booth']}}</span>
								</span>
							</a>

						</div>
					</div>
					<ul class="nav nav-warning">
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menu</h4>
						</li>
						<li class="nav-item {{Request::segment(1) === 'kasir' && Request::segment(2) != 'transaksi' && Request::segment(2) != 'stok' && Request::segment(3) != 'pesanan' && Request::segment(2) != 'report' ? 'active' : null}}">
							<a href="{{ route('kasir.dashboard') }}">
								<i class="fas fa-laptop"></i>
								<p>Kasir</p>
							</a>
						</li>
						<li class="nav-item {{Request::segment(2) === 'transaksi' && Request::segment(3) != 'pesanan' ? 'active' : null}}">
							<a href="{{ route('kasir.transaksi') }}">
								<i class="fas fa-clipboard-list"></i>
								<p>Transaksi</p>
							</a>
						</li>
						<li class="nav-item {{Request::segment(2) === 'report' && Request::segment(3) != 'pesanan' ? 'active' : null}}">
							<a href="{{ route('kasir.report') }}">
								<i class="far fa-file"></i>
								<p>Laporan Harian</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Stok</h4>
						</li>
						<li class="nav-item {{Request::segment(2) === 'stok'  ? 'active' : null}}">
							<a href="{{ route('kasir.stok') }}">
								<i class="fas fa-tags"></i>
								<p>Stok Produk</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Pesanan</h4>
						</li>
						<li class="nav-item {{Request::segment(3) === 'pesanan'  ? 'active' : null}}">
							<a href="{{ route('kasir.transaksi-pesanan') }}">
								<i class="fas fa-calendar-alt"></i>
								<p>Pesanan</p>
								<span class="badge badge-warning">{{PesananPendingB(session('login')['id_booth'])}}</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->
		
		{{-- Main Content --}}
		<div class="main-panel">
			<div class="content">
				@yield('content')
			</div>
			<footer class="footer">
				<div class="container-fluid">
					<nav class="pull-left">
						<ul class="nav">
							<li class="nav-item">
								<a class="nav-link">
									PawonLijo
								</a>
							</li>
						</ul>
					</nav>
					<div class="copyright ml-auto">
						2019, made by <a>mno.</a>
					</div>				
				</div>
			</footer>
		</div>
		{{-- End Main Content --}}
		
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('assets/atlantis/js/core/jquery.3.2.1.min.js') }}"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="{{ asset('assets/atlantis/js/core/popper.min.js') }}"></script>
	<script src="{{ asset('assets/atlantis/js/core/bootstrap.min.js') }}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('assets/atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/atlantis/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('assets/atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

	<!-- Atlantis JS -->
	<script src="{{ asset('assets/atlantis/js/atlantis.min.js') }}"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	@include('sweet::alert')
	
	@yield('js')
</body>
</html>