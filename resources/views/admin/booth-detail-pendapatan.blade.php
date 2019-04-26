@extends('admin/booth-detail')
@section('content2')	

	<div class="card" style="border: 1px solid #dddddd;">
		<div class="card-body">
			<h4><b><span class="fas fa-clipboard-list text-warning"></span>&nbsp; DAFTAR MENU</b></h4>
			<div class="separator-solid"></div>
			<div class="row">
				<div class="col-md-12">
					<div class="form-group" style="padding: 0;">
						<div class="input-icon">
							<input type="text" class="form-control" placeholder="Search for..." id="search" onkeyup="Search()" style="border: 1px #cccccc solid;">
							<span class="input-icon-addon">
								<i class="fa fa-search"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				
			</div>
		</div>
	</div>

@endsection
