{{Request::segment(3) != 'add-booth' ? session()->forget('step1') : null}}
{{Request::segment(3) != 'add-booth' ? session()->forget('step2') : null}}
{{Request::segment(3) != 'add-booth' ? session()->forget('step3') : null}}
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>PawonLijo</title>
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
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-envelope"></i>
								<span class="notification">4</span>
							</a>
							<ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
								<li>
									<div class="dropdown-title d-flex justify-content-between align-items-center">
										Messages 									
										<a href="#" class="small">Mark all as read</a>
									</div>
								</li>
								<li>
									<div class="message-notif-scroll scrollbar-outer">
										<div class="notif-center">
											<a href="#">
												<div class="notif-img"> 
													<img src="{{ asset('assets/atlantis/img/jm_denis.jpg') }}" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Jimmy Denis</span>
													<span class="block">
														How are you ?
													</span>
													<span class="time">5 minutes ago</span> 
												</div>
											</a>
											<a href="#">
												<div class="notif-img"> 
													<img src="../assets/img/chadengle.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Chad</span>
													<span class="block">
														Ok, Thanks !
													</span>
													<span class="time">12 minutes ago</span> 
												</div>
											</a>
											<a href="#">
												<div class="notif-img"> 
													<img src="../assets/img/mlane.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Jhon Doe</span>
													<span class="block">
														Ready for the meeting today...
													</span>
													<span class="time">12 minutes ago</span> 
												</div>
											</a>
											<a href="#">
												<div class="notif-img"> 
													<img src="../assets/img/talha.jpg" alt="Img Profile">
												</div>
												<div class="notif-content">
													<span class="subject">Talha</span>
													<span class="block">
														Hi, Apa Kabar ?
													</span>
													<span class="time">17 minutes ago</span> 
												</div>
											</a>
										</div>
									</div>
								</li>
								<li>
									<a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
								</li>
							</ul>
						</li>
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ asset('assets/atlantis/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
								</div> 
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{ asset('assets/atlantis/img/profile.jpg') }}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>Hizrian</h4>
												<p class="text-muted">hello@example.com</p><a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#">Account Setting</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#">Logout</a>
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
							<img src="{{ asset('assets/atlantis/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									Hizrian
									<span class="user-level">Administrator</span>
								</span>
							</a>

						</div>
					</div>
					<ul class="nav nav-warning">
						<li class="nav-item {{Request::segment(1) === 'admin' && Request::segment(2) === null  ? 'active' : null}} {{Request::segment(1) === 'admin' && Request::segment(2) === 'dashboard'  ? 'active' : null}}">
							<a href="{{ route('admin.dashboard') }}">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>	
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menu</h4>
						</li>
						<li class="nav-item {{Request::segment(2) === 'booth' ? 'active' : null}}">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-store"></i>
								<p>Booth PawonLijo</p>
								<span class="caret"></span>
							</a>
							<div class="collapse {{Request::segment(2) === 'booth' ? 'show' : null}}" id="base">
								<ul class="nav nav-collapse">
									<li class="{{Request::segment(3) === 'booth-pawonlijo' ? 'active' : null}}">
										<a href="{{ route('admin.booth') }}">
											<span class="sub-item">Booth PawonLijo</span>
										</a>
									</li>
									<li class="{{Request::segment(3) === 'add-booth' ? 'active' : null}}">
										<a href="{{ route('admin.add-booth') }}">
											<span class="sub-item">Tambah Booth Baru</span>
										</a>
									</li>
									<li class="{{Request::segment(3) === 'note-booth' ? 'active' : null}}">
										<a href="{{ route('admin.note-booth') }}">
											<span class="sub-item">Note Booth</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item {{Request::segment(2) === 'product' ? 'active' : null}}">
							<a href="{{ route('admin.product') }}">
								<i class="fas fa-tags"></i>
								<p>Produk</p>
							</a>
						</li>
						
						<li class="nav-item {{Request::segment(2) === 'sales' ? 'active' : null}}">
							<a href="{{ route('admin.sales') }}">
								<i class="fas fa-sign-in-alt"></i>
								<p>Data Penjualan</p>
							</a>
						</li>
						<li class="nav-item {{Request::segment(2) === 'report' ? 'active' : null}}">
							<a href="{{ route('admin.report') }}">
								<i class="fas fa-chart-bar"></i>
								<p>Laporan</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Stok</h4>
						</li>
						<li class="nav-item {{Request::segment(2) === 'stock-product' ? 'active' : null}}">
							<a href="{{ route('admin.stock-product') }}">
								<i class="fas fa-dolly"></i>
								<p>Stok Produk</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Pesanan</h4>
						</li>
						<li class="nav-item {{Request::segment(2) === 'pesanan' ? 'active' : null}}">
							<a href="{{ route('admin.pesanan') }}">
								<i class="far fa-calendar-alt"></i>
								<p>Pesanan</p>
								<span class="badge badge-warning">{{PesananPending()}}</span>
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