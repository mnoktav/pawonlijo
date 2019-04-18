@extends('kasir/master-d')
@section('css')
	<style>
		.table td{
			height: 2.5rem;
			font-size: 0.8rem;
		}
		.bayar p{
			font-size: 0.8rem;
			margin-bottom: 0.3rem;
		}
		.bayar input{
			font-size: 0.8rem;
			height: 2rem !important;
		}
	</style>
@endsection
@section('content')
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12" id="produk">
				<div class="card border">
					<div class="card-body">
						<div class="row">
							<div class="col-md-8">
								<h4 style="text-transform: uppercase;"><b>PRODUK {{session('login')['nama_booth']}}</b></h4>
								<small style="text-transform: uppercase;">Order : {{$jenis}}</small>

							</div>
							<div class="col-md-4 mt-2">
								<div class="text-right">
									<a class="btn btn-sm btn-rounded btn-primary mr-2" href="{{ route('kasir.dashboard') }}">
										<span class="btn-label">
											<i class="fas fa-angle-left"></i>
										</span>
										Kembali
									</a>
									<a class="btn btn-sm btn-rounded btn-warning" href="{{ url('/kasir/checkout?jenis='.$jenis) }}">
										<b>Checkout</b>
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
							<div class="col-md-3 target">
								<div class="card border">
									<form action="{{ route('kasir.product-add') }}" method="POST">
									@csrf
									<input type="hidden" name="jenis" value="{{$jenis}}">
									<div class="card-body list-produk" style="background-color: #f4f4f4;">
										<div class="row">
											<div class="col-9">
												<div class="produk mb-3">
													<h5 style="text-transform: capitalize;"><b><i class="fas fa-tag text-danger mr-2"></i>{{$product->nama_makanan}}</b></h5>
													@if ($jenis == 'Reguler' or $jenis == 'Pesanan')
														<p class="ml-3 pl-1">Rp {{$product->harga_reguler}}</p>
														<input type="hidden" name="harga" value="{{$product->harga_reguler}}">
													@elseif($jenis == 'Grab')
														<p class="ml-3 pl-1">Rp {{$product->harga_grab}}</p>
														<input type="hidden" name="harga" value="{{$product->harga_grab}}">
													@elseif($jenis == 'Gojek')
														<p class="ml-3 pl-1">Rp {{$product->harga_gojek}}</p>
														<input type="hidden" name="harga" value="{{$product->harga_gojek}}">
													@endif
													
													<input type="hidden" name="id_product" value="{{$product->id}}">
												</div>
											</div>
											<div class="col-3 {{$jenis == 'Pesanan' ? 'd-none':null}}">
												<p><b>Stok</b></p>
												@foreach ($stok as $s)
													@if($s->id_produk == $product->id)
														<p class="mt--3">{{$s->sisa_stok}}</p>
														<input type="hidden" name="sisa" value="{{$s->sisa_stok}}">
													@endif
												@endforeach
											</div>
											<div class="col-12">
												<div class="form-group p-0">	
												    <input type="text" class="form-control border mr-6 ml-6" id="jumlah" name="jumlah" placeholder="Jumlah">
												</div>
											</div>
										</div>
										<div class="separator-solid" style="border-top: 1px solid #969696;"></div>
										<div class="button-submit text-center">
											<input type="submit" name="pesan" value="Pesan" class="btn btn-primary btn-rounded btn-sm">
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
@endsection