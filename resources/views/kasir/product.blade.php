@extends('kasir/master-d')
@section('css')
	
@endsection
@section('content')
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12" id="produk">
				<div class="card border">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<h4 style="text-transform: uppercase;"><b>PRODUK {{session('login')['nama_booth']}}</b></h4>
								<small style="text-transform: uppercase;">Order : {{$jenis}}</small>

							</div>
							<div class="col-md-6 mt-2">
								<div class="text-right">
									@if(session('cart') == null)
									<a class="btn btn-sm btn-rounded btn-primary mr-2" href="{{ route('kasir.dashboard') }}">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
									@else
									<a class="btn btn-sm btn-rounded btn-primary mr-2 reset" href="{{ route('kasir.product-reset-back') }}">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
									@endif
									<a class="btn btn-sm btn-rounded btn-success" href="{{ route('kasir.checkout',['jenis'=>$jenis, 'id'=>$id_jenis]) }}">
										<b>Checkout</b>
										@if(session('cart') != null)
											<span class="ml-2">{{count(session('cart'))}} item</span>
										@endif
									</a>
								</div>
							</div>
						</div>
						<div class="separator-solid"></div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group" style="padding: 0; margin-bottom: 1rem;">
									<div class="input-icon">
										<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
										<span class="input-icon-addon">
											<i class="fa fa-search"></i>
										</span>
									</div>
								</div>
							</div>
							@foreach ($products as $product)
							<div class="col-md-4 target">
								<div class="card border">
									<form action="{{ route('kasir.product-add') }}" method="POST">
									@csrf
									<input type="hidden" name="jenis" value="{{$jenis}}">
									<div class="card-body list-produk" style="background-color: #f4f4f4;">
										<div class="row">
											<div class="col-8">
												<div class="produk mb-3">
													<h5 style="text-transform: capitalize;"><b><i class="fas fa-tag text-danger mr-2"></i>{{$product->nama_makanan}}</b></h5>
													<p class="ml-3 pl-1">Rp {{Rupiahd($product->harga)}}</p>
													<input type="hidden" name="harga" value="{{$product->harga}}">
													
													<input type="hidden" name="id_product" value="{{$product->id_produk}}">
													<input type="hidden" name="id_jenis" value="{{$product->id_jenis_transaksi}}">
												</div>
											</div>
											<div class="col-4 {{$jenis == 'Pesanan' ? 'd-none':null}}">
												<p><b>Stok</b></p>
												@foreach ($stok as $s)
													@if($s->id_produk == $product->id_produk)
														@if (!empty(session('cart')[$product->id_produk]['jumlah']))
															<p class="mt--3">{{$s->sisa_stok-session('cart')[$product->id_produk]['jumlah']}}</p>
															<input type="hidden" name="sisa" value="{{$s->sisa_stok}}">
														@else
															<p class="mt--3">{{$s->sisa_stok}}</p>
															<input type="hidden" name="sisa" value="{{$s->sisa_stok}}">
														@endif
														
													@endif
												@endforeach
											</div>
											<div class="col-7">
												<div class="form-group p-0">	
												    <input type="number" class="form-control border mr-6 ml-6" id="jumlah" name="jumlah" placeholder="Jumlah" min="1">
												</div>
											</div>
											<div class="col-5 mt-1">
												<div class="button-submit text-center">
													<input type="submit" name="pesan" value="Pesan" class="btn btn-primary btn-sm">
												</div>
											</div>
										</div>
										
									</div>
									</form>
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
		    $('.reset').on('click', function(e){
		        e.preventDefault(); //cancel default action

		        //Recuperate href value
		        var href = $(this).attr('href');
		        var message = $(this).data('confirm');

		        //pop up
		        swal({
		            title: "Transaksi Belum Selesai",
		            text: "Item dihalaman checkout akan dihapus", 
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