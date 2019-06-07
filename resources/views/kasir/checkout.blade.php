@extends('kasir/master-d')
@section('css')
	<style>
		.table td{
			height: 3rem;
			font-size: 1rem;
			padding: 0.5rem !important;
		}

		.form-group input{
			border: 1px solid #aaaaaa;
			height: 2.5rem !important;
		}
		.form-group{
			padding: 0.5rem 0;
		}
	</style>
@endsection
@section('content')
	<div class="page-inner">
		{{-- <form action="" method="GET"> --}}
			<div class="row">
				<div class="col-md-8 offset-md-2">
					
					<div class="card border">
						<div class="card-body">
							@if(session('cart'))
							<div class="row">
								<div class="col-8 mt-2">
									<h4><b>CHECKOUT</b></h4>
								</div>
								<div class=" col-4 text-right">
									<a href="/kasir/product/{{$id_jenis}}/{{$jenis}}" class="btn btn-primary btn-rounded btn-sm mb-3">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
								</div>
							</div>
							<div class="separator-solid mt-0"></div>
							<form action="{{ route('kasir.product-update') }}" method="POST">
							@csrf
								<input type="hidden" name="jenis" value="{{$jenis}}">
								
								<table class="table table-striped border">
									{{-- order --}}
									@php
										$subtotal = 0;
									@endphp
									@foreach (session('cart') as $id => $order)
									@php
										$total_item = $order['harga'] * $order['jumlah'];
										$subtotal += $total_item;
									@endphp
									{{-- produk --}}
										<tr>
											<td colspan="3">
												<b>{{$order['nama_produk']}}</b> 
												<a href="{{ route('kasir.product-remove', $id) }}" class="ml-4 p-1 pl-2 pr-2" style="background-color: white; border-radius: 1rem; float: right;" >
													<i class="fas fa-trash text-warning"></i>
												</a>
											</td>
											<input type="hidden" name="id_product[]" value="{{$id}}">
										</tr>
										<tr>
											<td width="40%" class="p-3">
												Rp {{Rupiahd($order['harga'])}}
												
											</td>
											<td width="20%">
												<input type="text" name="jumlah[]" value="{{$order['jumlah']}}" class="form-control"  style="height: 1.8rem !important; width: 2rem; font-size: 0.8rem; border-radius: 5px; border: 1px solid #aaaaaa; padding: 5px">
											</td>

											<td width="40%">Rp {{Rupiahd($total_item)}}</td>
										</tr>

									@endforeach
									{{-- subtotal --}}
									<tr>
										<td colspan="2"><b>SUBTOTAL</b></td>
										<td>Rp {{Rupiahd($subtotal)}}</td>
									</tr>
								</table>
								<div class="row">
									<div class="col-6">
										<a href="{{ route('kasir.product-reset') }}" class="btn btn-danger reset">Reset</a>
									</div>
									<div class="col-6 text-right">
										<input type="submit" value="Update" name="update_cart" class="btn btn-primary">
									</div>
								</div>
							</form>
							<br>
							<form action="{{ route('kasir.checkout-save') }}" method="POST">
								@csrf	
								<div class="row">
									<input type="hidden" name="id_jenis" value="{{$id_jenis}}">
									<input type="hidden" name="jenis" value="{{$jenis}}">
									<input type="hidden" name="id_booth" value="{{session('login')['id_booth']}}">
									<div class="col-md-6 col-6">
										<div class="form-group">
											<label for="">POTONGAN</label>
											<input type="text" class="form-control potongan numeric" name="potongan" value="" id="potongan">
										</div>
									</div>
									<div class="col-md-6 col-6">
										<div class="form-group">
											<label for="">TOTAL</label>
											<input type="hidden" name="subtotal" class="subtotal numeric" id="subtotal" value="{{$subtotal}}">
											<input type="text" class="form-control total numeric" name="total" id="total" value="{{$subtotal}}" readonly style="background-color: white !important; color: black; border: 1px solid #aaaaaa !important;">
										</div>
									</div>
									<div class="col-md-6 col-6">
										<div class="form-group">
											<label for="">UANG BAYAR</label>
											<input type="text" class="form-control bayar numeric" id="bayar" name="bayar">
										</div>
									</div>
									<div class="col-md-6 col-6">
										<div class="form-group">
											<label for="">UANG KEMBALI</label>
											<input type="text" class="form-control kembali numeric" id="kembali" name="kembali" style="background-color: white !important; color: black; border: 1px solid #aaaaaa !important;" readonly >
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="">NAMA</label>
											<input type="text" class="form-control" name="nama">
										</div>
									</div>
									@if($jenis != 'Reguler' && $jenis != 'Pesanan')
									<div class="col-md-12">
										<div class="form-group">
											<label for="">KODE PESANAN</label>
											<input type="text" class="form-control" name="kode" placeholder="{{$jenis}}">
										</div>
									</div>
									@endif
									@if($jenis == 'Pesanan')
									<div class="col-md-12">
										<div class="form-group">
											<label for="">Keterangan</label>
											<textarea name="keterangan" class="form-control" required="" placeholder="tanggal ambil atau alamat pengantaran" rows="5" style="border-color: #aaaaaa"></textarea>
											
										</div>
									</div>
									@endif
								</div>
								<div class="separator-solid"></div>
								<div class="text-center">
									<input type="submit" value="Simpan & Cetak" name="simpan_cetak" class="btn btn-success btn-rounded">
								</div> 
							</form>
							@else
							<div class="row">
								<div class="col-8 mt-2">
									<h4><b>CHECKOUT</b></h4>
								</div>
								<div class=" col-4 text-right">
									<a href="/kasir/product/{{$id_jenis}}/{{$jenis}}" class="btn btn-primary btn-rounded btn-sm mb-3">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
								</div>
							</div>
							<div class="separator-solid mt-0"></div>
							<h3 align="center" class="mt-2">Belum Ada Makanan Yang Dipesan</h3>
							@endif
						</div>
					</div>
				</div>
			</div>
		{{-- </form> --}}
	</div>

@endsection

@section('js')
	<script src="{{ asset('assets/anum/autoNumeric.js') }}"></script>
	
	<script>
		$(document).ready(function(){
		    $('.reset').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Apakah anda yakin ingin mereset keranjang?",
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
		$(document).ready(function() { 
			$('.numeric').autoNumeric('init', {
				aSep: '.', 
	    		aDec: ',',
	    		mDec: '0'
			});
		});
	</script>
	<script>
	    $(document).ready(function(){

	       $('#potongan').bind('keyup', function(e) {	
	        var subtotal = $('#subtotal').autoNumeric('get');
	        var potongan = $('#potongan').autoNumeric('get');

	        var total = subtotal - potongan;

	        $("#total").val(total);
	      });

	       $('#bayar').bind('keyup', function(e) {
	        var total = $('#total').autoNumeric('get');
	        var bayar = $('#bayar').autoNumeric('get');
	        var kembali = bayar - total;
	        $("#kembali").val(kembali);
	      });
	    });
	</script>
	
@endsection