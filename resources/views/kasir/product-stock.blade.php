@extends('kasir/master-d')
@section('content')	
	<div class="page-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>STOK PRODUK</b></h4>
								<small>{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
							</div>
						</div>
						<div class="separator-solid"></div>
						
						<div class="table-responsive">
							<table class="table table-striped">
								<thead class="bg-dark text-light">
									<tr>
										<th width="25%">Nama Makanan</th>
										<th>Stok Hari Ini</th>
										<th>Sisa Stok Hari Ini</th>
										<th>Terjual Hari Ini</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($products as $product)
											
										
										<tr>
											<td>
												{{$product->nama_makanan}}
											</td>
											

											<td>
												@foreach ($stocks as $stock)

													{{$stock->id_produk == $product->id ? $stock->total_stok : null}}
												@endforeach
											</td>
											<td>
												@foreach ($stocks as $stock1)
													{{$stock1->id_produk == $product->id ? $stock1->sisa_stok : null}}
												@endforeach
											</td>
											<td>
												@foreach ($terjual as  $t)
													{{$t->id_produk == $product->id ? $t->jumlah : null}}
												@endforeach
											</td>
										</tr>
										
									@endforeach
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
