@extends('admin/master-d')
@section('content')	
	<div class="page-inner">
		<div class="page-header">
			<h4 class="page-title">Stok Menu PawonLijo</h4>
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
					<a>Stok Menu PawonLijo</a>
				</li>
				<li class="separator">
					<i class="flaticon-right-arrow"></i>
				</li>
				<li class="nav-item">
					<a>Nama Booth</a>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-10">
								<h4><b>STOK PRODUK</b></h4>
								<small>{{$booth->nama_booth.', '.$booth->kota_booth.' ('.$booth->id_booth.')'}}</small><br>
							</div>
							<div class="col-md-2 text-right">
								<a class="btn btn-sm btn-rounded btn-primary" href="{{ route('admin.stock-product') }}">
									<span class="btn-label">
										<i class="fas fa-angle-left"></i>
									</span>
									Kembali
								</a>
							</div>
						</div>
						<div class="separator-solid"></div>
						<form action="{{ route('admin.stock-update') }}" method="POST">@csrf
						<div class="table-responsive">
							<table class="table table-striped">
								<thead class="bg-dark text-light">
									<tr>
										<th width="25%">Nama Makanan</th>
										<th>Stok Hari Ini</th>
										<th>Sisa Stok Hari Ini</th>
										<th>Terjual Hari Ini</th>
										<th>Update Stok</th>
										<th>Info Stok</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($products as $product)
											
										
										<tr>
											<td>
												{{$product->nama_makanan}}
												<input type="hidden" name="id_produk[]" value="{{$product->id}}">
												<input type="hidden" name="id_booth" value="{{$booth->id_booth}}">
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
											
											<td><input type="number" name="update_stok[]" min="1" style="border-radius: 4px; border: 1px solid #aaaaaa; width: 4rem; padding-left: 0.5rem;"></td>

											<td><a href="/admin/stock-product/{{$booth->id_booth}}/{{$product->id}}" class="btn btn-sm btn-primary btn-rounded"><i class="fas fa-info"></i></a></td>
										</tr>
										
									@endforeach
									
								</tbody>
							</table>
							<div class="text-center">
								<input type="submit" value="Update Stok" name="update" class="btn btn-success">
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
