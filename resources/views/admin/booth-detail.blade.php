@extends('admin/master-d')
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Nama Booth</h4>
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
					<a>Booth PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>{{$booth->nama_booth}}</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								@if($booth->status == 0)
									<h4><b>{{$booth->nama_booth}}, {{$booth->kota_booth}}</b> <i>(Nonaktif)</i></h4>
								@else
									<h4><b>{{$booth->nama_booth}}, {{$booth->kota_booth}}</b></h4>
								@endif
								<small class="text-secondary"><b>#{{$booth->id_booth}}</b></small>
							</div>
							<div class="col-lg-6 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.booth') }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									 Kembali
								</a>
								<a href="{{ route('admin.edit-booth',$booth->id_booth) }}" class="btn btn-sm btn-rounded btn-warning mr-2 ml-2">
									<span class="fas fa-user-edit"></span>
									 Edit Booth
								</a>
								@if($booth->status != 0)
								<a href="{{ route('admin.nonactive-booth',$booth->id_booth) }}" class="btn btn-sm btn-rounded btn-danger" id="n-booth">
									<span class="fas fa-exclamation-triangle"></span>
									 Nonaktifkan Booth
								</a>
								@else
								<a href="{{ route('admin.active-booth',$booth->id_booth) }}" class="btn btn-sm btn-rounded btn-success" id="a-booth">
									<span class="fas fa-check"></span>
									 Aktifkan Booth
								</a>
								@endif
							</div>
						</div>
						<div class="separator-solid"></div>
						<ul class="nav nav-pills nav-primary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
							<li class="nav-item">
								<a class="nav-link {{Route::is('admin.detail-booth') ? 'active' : null}}" href="{{ route('admin.detail-booth',$booth->id_booth) }}">Home</a>
							</li>
							<li class="nav-item">
								<a class="nav-link {{Route::is('admin.detail-booth-transaksi') ? 'active' : null}}" href="{{ route('admin.detail-booth-transaksi',$booth->id_booth) }}">Transaksi</a>
							</li>
							{{-- <li class="nav-item">
								<a class="nav-link {{Route::is('admin.detail-booth-menu') ? 'active' : null}}" href="{{ route('admin.detail-booth-menu',$booth->id_booth) }}">Daftar Menu</a>
							</li> --}}
						</ul>
						<div class="row" style="margin-top: 1rem">
							<div class="col-12">
								@yield('content2')

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script src="{{ asset('assets/atlantis/js/plugin/datatables/datatables.min.js') }}"></script>
	<script>
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
				 aaSorting: [[0, 'desc']]
			});
		})
	</script>
	<script>
		function Search() {
		  var input = document.getElementById("search");
		  var filter = input.value.toLowerCase();
		  var nodes = document.getElementsByClassName('target');
		  var hmmm = document.getElementsByClassName('nothing');

		  for (i = 0; i < nodes.length; i++) {
		    if (nodes[i].innerText.toLowerCase().includes(filter)) {
		      nodes[i].style.display = "block";
		    } else {
		      nodes[i].style.display = "none";
		    }
		  }
		}
	</script>
	<script>
		$(document).ready(function(){
		    $('#n-booth').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin menonaktifkan booth ini?",
		            text: message, 
		            icon: "warning",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
		          if (willDelete) {
		            window.location.href = href;
		          }
		        });
		    });
		});
	</script>
	<script>
		$(document).ready(function(){
		    $('#a-booth').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin mengaktifkan booth ini?",
		            text: message, 
		            icon: "warning",
		            buttons: true,
		            dangerMode: true,
		        })
		        .then((willDelete) => {
		          if (willDelete) {
		            window.location.href = href;
		          }
		        });
		    });
		});
	</script>
	<script>
		function LihatPassword() {
		  	var x = document.getElementById("password");
		  	if (x.type === "password") {
		    	x.type = "text";
			 } else {
			    x.type = "password";
			}
		}
	</script>
@endsection

