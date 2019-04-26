<?php

//Dashboard
Route::get('/admin/', 'AdminDashboard@index');
Route::get('/admin/dashboard', 'AdminDashboard@index')->name('admin.dashboard');

//Booth add
Route::get('/admin/booth/add-booth/step1', 'AdminBooth@AddBooth')->name('admin.add-booth');
Route::get('/admin/booth/add-booth/step2', 'AdminBooth@Step2')->name('admin.add-booth-step2');
Route::get('/admin/booth/add-booth/step3', 'AdminBooth@Step3')->name('admin.add-booth-step3');
Route::get('/admin/booth/add-booth/finish', 'AdminBooth@Step4')->name('admin.add-booth-step4');
Route::get('/admin/booth/add-booth/setup-menu', 'AdminBooth@Step5')->name('admin.add-booth-step5');
Route::post('/admin/booth/add-booth/save', 'AdminBooth@SaveStep')->name('admin.add-booth-save');

//Booth Note
Route::get('/admin/booth/note-booth', 'AdminBooth@NoteBooth')->name('admin.note-booth');
Route::get('/admin/booth/note-booth/add', 'AdminBooth@AddNoteBooth')->name('admin.add-note-booth');
Route::post('/admin/booth/note-booth/add/save', 'AdminBooth@SaveNote')->name('admin.save-note');
Route::get('/admin/booth/note-booth/delete/{judul}', 'AdminBooth@DeleteNote')->name('admin.delete-note');

//Booth
Route::get('/admin/booth/booth-pawonlijo', 'AdminBooth@Booth')->name('admin.booth');
Route::get('/admin/booth/booth-pawonlijo/{id_booth}', 'AdminBooth@DetailBoothHome')->name('admin.detail-booth');
Route::get('/admin/booth/booth-pawonlijo/{id_booth}/transaksi', 'AdminBooth@DetailBoothTransaksi')->name('admin.detail-booth-transaksi');
Route::get('/admin/booth/booth-pawonlijo/{id_booth}/pendapatan', 'AdminBooth@DetailBoothPendapatan')->name('admin.detail-booth-menu');
Route::get('/admin/booth/booth-pawonlijo/{id_booth}/edit', 'AdminBooth@EditBooth')->name('admin.edit-booth');
Route::post('/admin/booth/booth-pawonlijo/update', 'AdminBooth@UpdateBooth')->name('admin.update-booth');
Route::get('/admin/booth/booth-pawonlijo/delete/{id}', 'AdminBooth@DeleteKasir')->name('admin.delete-kasir');
Route::get('/admin/booth/booth-pawonlijo/non-activate/{id}', 'AdminBooth@NonBooth')->name('admin.nonactive-booth');
Route::get('/admin/booth/booth-pawonlijo/activate/{id}', 'AdminBooth@ActBooth')->name('admin.active-booth');


//produk
Route::get('/admin/product', 'AdminProduct@index')->name('admin.product');
Route::get('/admin/product/add', 'AdminProduct@ProductAdd')->name('admin.product-add');
Route::post('/admin/product/save', 'AdminProduct@ProductSave')->name('admin.product-save');
Route::get('/admin/product/booth/{id_booth}', 'AdminProduct@ProductBooth')->name('admin.product-booth-menu');
Route::get('/admin/product/booth/{id_booth}/{id}', 'AdminProduct@ProductInfo')->name('admin.product-booth-menu-info');
Route::get('/admin/product/booth/{id_booth}/edit/{id}', 'AdminProduct@ProductEdit')->name('admin.product-booth-menu-edit');
Route::post('/admin/product/update', 'AdminProduct@ProductUpdate')->name('admin.product-update');
Route::get('/admin/product/delete/{id}', 'AdminProduct@ProductDelete')->name('admin.product-delete');
Route::get('/admin/product/delete-p/{id}', 'AdminProduct@ProductDeletePer')->name('admin.product-deletep');
Route::get('/admin/product/back/{id}', 'AdminProduct@ProductBack')->name('admin.product-back');
Route::get('/admin/product/stats', 'AdminProduct@ProductStats')->name('admin.product-stats');

//stok produk
Route::get('/admin/stock-product', 'AdminProduct@StockProduct')->name('admin.stock-product');
Route::post('/admin/stock-product/update', 'AdminProduct@StockUpdate')->name('admin.stock-update');
Route::get('/admin/stock-product/{id_booth}', 'AdminProduct@StockProductBooth')->name('admin.stock-product-booth');
Route::get('/admin/stock-product/{id_booth}/{id}', 'AdminProduct@StockProductHistory')->name('admin.stock-product-history');

//sales
Route::get('/admin/sales', 'AdminSales@index')->name('admin.sales');
Route::get('/admin/pesanan', 'AdminSales@Pesanan')->name('admin.pesanan');
Route::get('/admin/sales/detail/{id}', 'AdminSales@Detail')->name('admin.sales-detail');
Route::get('/admin/pesanan/detail/{id}', 'AdminSales@Detail')->name('admin.pesanan-detail');

//report
Route::get('/admin/report', 'AdminReport@index')->name('admin.report');


//kasir-login
Route::get('/kasir/login', 'KasirLogin@index')->name('kasir.login');
Route::post('/kasir/login', 'KasirLogin@Login')->name('kasir.login-kasir');
Route::get('/kasir/logout', 'KasirLogin@Logout')->name('kasir.logout');

//kasir-dashboard
Route::get('/kasir', 'KasirDashboard@index')->name('kasir.dashboard');
Route::get('/kasir/product', 'KasirDashboard@KasirProduct')->name('kasir.product');
Route::post('/kasir/product/add', 'KasirDashboard@AddToCart')->name('kasir.product-add');
Route::post('/kasir/product/update', 'KasirDashboard@UpdateCart')->name('kasir.product-update');
Route::get('/kasir/product/remove/{id_product}', 'KasirDashboard@RemoveFromCart')->name('kasir.product-remove');
Route::get('/kasir/product/reset', 'KasirDashboard@RemoveCart')->name('kasir.product-reset');
Route::get('/kasir/product/reset-back', 'KasirDashboard@RemoveCartBack')->name('kasir.product-reset-back');
Route::get('/kasir/checkout', 'KasirDashboard@Checkout')->name('kasir.checkout');
Route::post('/kasir/checkout/save', 'KasirDashboard@SaveCheckout')->name('kasir.checkout-save');
Route::get('/kasir/print-nota/{id}', 'KasirDashboard@PrintNota')->name('kasir.print-nota');

//kasir-transaksi
Route::get('/kasir/transaksi', 'KasirSales@index')->name('kasir.transaksi');
Route::get('/kasir/transaksi/pesanan', 'KasirSales@SalesPesanan')->name('kasir.transaksi-pesanan');
Route::get('/kasir/transaksi/pesanan/{id}', 'KasirSales@Detail')->name('kasir.transaksi-detail-pesanan');
Route::get('/kasir/transaksi/pesanan/update/{id}', 'KasirSales@PesananSelesai')->name('kasir.transaksi-update-pesanan');
Route::get('/kasir/transaksi/{id}', 'KasirSales@Detail')->name('kasir.transaksi-detail');
Route::post('/kasir/transaksi/batal', 'KasirSales@TransaksiBatal')->name('kasir.transaksi-batal');

//kasir stok
Route::get('/kasir/stok', 'KasirSales@StockProduct')->name('kasir.stok');
Route::get('/kasir/report', 'KasirReport@index')->name('kasir.report');
