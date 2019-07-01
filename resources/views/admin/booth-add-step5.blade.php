@extends('admin/booth-add')
@section('css')
	<style>
		.form-control{
			height: 2rem !important;
			border: 1px solid #aaaaaa;
		}
	</style>
@endsection
@section('step')
	<div class="card" style="border: 1px solid #dddddd">
		<div class="card-body step">
			<div class="row">
				<div class="col-md-12" style="padding: 1rem;">
					<h3><i class="fas fa-check text-warning"></i> &nbsp; <b>BERHASIL</b></h3>
					<div class="separator-solid" style="border-color: #dddddd"></div>
					<div class="alert alert-info bg-info text-light" role="alert">
					  <i class="fas fa-check-circle"></i> &nbsp;<b>BOOTH BARU BERHASIL DIBUAT!</b>
					</div>
				</div>
				<form action="{{ route('admin.add-booth-save') }}" method="POST">
					@csrf
					<div class="col-md-12" id="daftar-menu">
						<div class="card border shadow-none">
							<div class="card-body" style="height: 500px; overflow-y: scroll;">
								<h5><b>DAFTAR MENU</b></h5>
								<div class="separator-solid"></div>
								<table class="table table-bordered">
									<tr>
										<th><input type="checkbox" class="mr-1" id="select-all"></th>
										<th width="20%">Nama</th>
										@foreach ($jenis as $e)
										
										<th>{{$e->jenis_transaksi}}</th>
										@endforeach
										
									</tr>
									<input type="hidden" name="id_booth" value="{{$booth}}">
									@php
											$i = 0;
										@endphp
									@foreach ($products as $p)
									<tr>
										@php
											$b = $i++;
										@endphp
										<td width="5%"><input type="checkbox" class="checkitem" name="index[]" value="{{$b}}">
											<input type="hidden" name="nama_makanan[]" value="{{$p->nama_makanan}}"></td>
										<td width="15%">{{$p->nama_makanan}} <input type="hidden" name="kategori[]" value="{{$p->kategori}}"></td>
										
										@foreach ($jenis as $je)
										<td><input type="text" class="form-control" name="harga[{{$b}}][]" value="{{GetHarga($p->id,$je->jenis_transaksi)}}" onkeypress="return NumberOnly()"></td>
										@endforeach
									</tr>
									@endforeach
								</table>
								
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="text-center">
							<input type="submit" name="selesai" value="Tambahkan" class="btn btn-primary btn-sm">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
@endsection
@section('js')
	<script>
		$(document).ready(function() {
	        $('#select-all').click(function(event) {  
	            if(this.checked) { 
	                $('.checkitem').each(function() { 
	                    this.checked = true;     
	                });
	            }else{
	                $('.checkitem').each(function() {
	                    this.checked = false; 
	                });        
	            }
	        });

	    });
	</script>
	<script>
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
		window.onhashchange=function(){window.location.hash="no-back-button";}
	</script> 
@endsection
