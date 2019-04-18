@extends('admin/master-d')
@section('css')
	<style>
		.note{
			border: 1px solid #dddddd;
		}
		.note .card-body{
			background-color: #fcffcc;
		}
		.note .tanggal{
			margin-bottom: 0.5rem;
		}
		
	</style>
@endsection
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Note Booth PawonLijo</h4>
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
					<a>Note Booth PawonLijo</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8 mt-2">
								<a class="btn btn-primary btn-rounded" href="{{ route('admin.add-note-booth') }}">Tambah Note</a>
							</div>
							<div class="col-md-4">
								<div class="form-group" style="padding: 0.5rem 0;">
									<div class="input-icon">
										<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
										<span class="input-icon-addon">
											<i class="fa fa-search"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="separator-solid"></div>
							</div>
							@foreach ($notes as $note)
							<div class="col-md-3 target">
								<div class="card note">
									<div class="card-body">
										<div class="tanggal text-right">
											<small>{{date('d/m/Y', strtotime($note->created_at))}}</small>
										</div>
										<div class="title">
											<b>Untuk : </b><br>{{$note->nama_booth}}
											
										</div>
										<div></div>
										<div class="separator-solid" style="border-color: #b2b2b2"></div>
										<b>Pesan :</b><br>
										<p class="m-0" style="text-transform: capitalize; font-size: 1rem; font-weight: bolder;">{{$note->judul}}</p>
										{{$note->pesan}}
										<div class="separator-solid" style="border-color: #b2b2b2"></div>
										<div class="text-right">
											<a href="{{ route('admin.delete-note',$note->judul) }}" class="btn btn-icon btn-sm btn-round btn-danger hapus-note">
												<i class="fas fa-trash-alt mt-2"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
							@endforeach
							@if (count($notes) == null)
								<div class="col-md-12 text-center mt-4">
									<h4>Tidak Ada Note.</h4>
								</div>
							@endif
						</div>

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
	<script>
		$(document).ready(function(){
		    $('.hapus-note').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin?",
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
@endsection
