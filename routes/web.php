<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AdminController@index');
Route::get('dashboard', 'AdminController@dashboard');

Auth::routes(['register'=>false]);

Route::get('teknisi', 'TeknisiController@index');
Route::resource('teknisi', 'TeknisiController');
Route::get('api.teknisi', 'TeknisiController@apiTeknisi')->name('api.teknisi');

Route::get('supplier', 'SupplierController@index');
Route::get('api.supplier', 'SupplierController@apiSupplier')->name('api.supplier');
Route::resource('supplier', 'SupplierController');

Route::get('customer', 'CustomerController@index');
Route::get('api.pelanggan', 'CustomerController@apiPelanggan')->name('api.pelanggan');
Route::resource('customer', 'CustomerController');

Route::get('job', 'JobController@index');
Route::get('api.job', 'JobController@apiJob')->name('api.job');
Route::resource('job', 'JobController');

Route::get('kategori', 'CategoryController@index');
Route::get('api.kategori', 'CategoryController@apiKategori')->name('api.kategori');
Route::resource('kategori', 'CategoryController');

Route::get('unit', 'UnitController@index');
Route::get('api.unit', 'UnitController@apiUnit')->name('api.unit');
Route::resource('unit', 'UnitController');

Route::get('good', 'GoodController@index');
Route::get('api.good', 'GoodController@apiGood')->name('api.good');
Route::resource('good', 'GoodController');
Route::post('setbaku', 'GoodController@tambahBahanBaku');
Route::post('updatebaku', 'GoodController@updateBahanBaku');
Route::get('editBaku/{id}', 'GoodController@editBahanBaku');
Route::post('hapusBaku', 'GoodController@hapusBahanBaku');
Route::post('materiallist', 'GoodController@materiallist');

Route::get('material', 'MaterialController@index');
Route::get('api.material', 'MaterialController@apiMaterial')->name('api.material');
Route::resource('material', 'MaterialController');

Route::get('foto/{id}', 'GoodController@getFoto');

Route::get('cost', 'CostController@index');
Route::get('api.cost', 'CostController@apiCost')->name('api.cost');
Route::resource('cost', 'CostController');


Route::get('purchase', 'PurchaseController@index');
Route::get('api.purchase', 'PurchaseController@apiPurchase')->name('api.purchase');
Route::get('addPurchase', 'PurchaseController@addPurchase');

Route::get('user', 'UserController@index');
Route::get('api.user', 'UserController@apiUser')->name('api.user');
Route::resource('user', 'UserController');

Route::get('expense', 'ExpenseController@index');
Route::get('api.expense', 'ExpenseController@apiExpense')->name('api.expense');
Route::resource('expense', 'ExpenseController');



// laporan
Route::get('lapserv', 'LaporanServiceController@index');
Route::get('servcetak/{dari}/{akhir}', 'LaporanServiceController@servPDF')->name('lap.serve');

Route::get('lapexp', 'LaporanServiceController@expense');
Route::get('expcetak/{dari}/{akhir}', 'LaporanServiceController@expPDF')->name('lap.exp');

Route::get('lappur', 'LaporanServiceController@purchase');
Route::get('purcetak/{dari}/{akhir}', 'LaporanServiceController@purPDF')->name('lap.pur');

Route::get('lapstok', 'LaporanServiceController@stok');
Route::get('lapstokbaku', 'LaporanServiceController@stokbaku');
Route::get('stokcetak/{kategori?}', 'LaporanServiceController@stokPDF')->name('lap.stok');
Route::get('stokcetakbaku/{kategori?}', 'LaporanServiceController@stokbakuPDF')->name('lap.stokbaku');
Route::get('struk/{id}', 'StrukController@index');

Route::get('laphistok', 'LaporanServiceController@laphistok');
Route::get('hiscetak/{id}/{dari}/{sampai}', 'LaporanServiceController@hisPDF');




// purchasing

Route::get('caribrg/{brg}', 'PurchaseController@cari');

Route::get('api.item', 'PurchaseController@apiItem')->name('api.item');
Route::post('simpan_item', 'PurchaseController@simpan_item');
Route::delete('item_hapus/{id}', 'PurchaseController@destroy');
Route::get('total_purchase', 'PurchaseController@totalTransaksi');
Route::get('editItem/{id}', 'PurchaseController@editItem');
Route::post('item_update', 'PurchaseController@updateItem');
Route::post('simpan_purchase', 'PurchaseController@simpanPurchase');
Route::delete('hapus_pembelian', 'PurchaseController@hapusPembelian');
Route::post('batal_pembelian', 'PurchaseController@batalPembelian');
Route::get('lihat_pembelian/{id}/{inv}', 'PurchaseController@lihatPembelian');
Route::get('cetak_pembelian/{id}/{inv}', 'PurchaseController@cetakPembelian');
Route::get('edit_pembelian/{inv}', 'PurchaseController@editPembelian');
Route::post('update_purchase', 'PurchaseController@updatePembelian');

//tanda terima

Route::get('tterima', 'TterimaController@index');
Route::get('api.terima', 'TterimaController@apiTerima')->name('api.terima');
Route::resource('tterima', 'TterimaController');
Route::get('cetak_tanda_terima/{id}', 'TterimaController@cetakTerima');
Route::post('cancel_tt', 'TterimaController@cancelTT');
Route::get('lihat_gambar_tt/{id}', 'TterimaController@lihatGambar');
//service

Route::resource('service', 'ServiceController');
Route::get('api.service', 'ServiceController@apiService')->name('api.service');
Route::get('api.service-tmp', 'ServiceController@apiServiceTmp')->name('api.service-tmp');
Route::get('api.service-tt', 'ServiceController@apiServiceTerima')->name('api.service-tt');
Route::get('pilih_terima/{id}', 'ServiceController@pilihTerima');
Route::get('tambah_jasa/{id}', 'ServiceController@tambahJasa');
Route::get('tambah_barang/{id}', 'ServiceController@tambahBarang');
Route::get('total_service', 'ServiceController@totalService');
Route::post('item', 'ServiceController@storeBarang');
Route::patch('item/{id}', 'ServiceController@updateBarang');
Route::post('simpan_service', 'ServiceController@simpanService');
Route::get('batal_service', 'ServiceController@batalService');
Route::delete('hapus_service/{inv}', 'ServiceController@hapusService');
Route::get('edit_service/{inv}/{ttno}', 'ServiceController@editService');
Route::post('update_service', 'ServiceController@updateService');
Route::get('cetak_invoice_service/{id}', 'ServiceController@cetakService');
Route::get('select_barang/{id}', 'ServiceController@selectBarang');

// hutang supplier

Route::get('debt', 'DebtController@index');
Route::get('api.debt', 'DebtController@apiDebt')->name('api.debt');
Route::get('api.list_purchase', 'DebtController@apiList')->name('api.list_purchase');
Route::get('pilih_hutang/{id}', 'DebtController@pilihHutang');
Route::post('simpan_pembayaran', 'DebtController@simpanPembayaran');
Route::post('hapus_pembayaran', 'DebtController@hapusPembayaran');
Route::get('get_data_payment/{id}', 'DebtController@getPayment');
Route::post('update_pembayaran', 'DebtController@updatePembayaran');
Route::get('cetak_pembayaran/{id}/{invoice}', 'DebtController@cetakPembayaran');
Route::get('report_debt', 'DebtController@cetakLaporanHutang');
Route::get('hutang_cetak_sekarang/{periode?}', 'DebtController@hutangCetakSekarang');
Route::get('report_payment', 'DebtController@cetakLaporanPembayaran');
Route::get('pembayaran_cetak_sekarang/{supplier?}', 'DebtController@pembayaranCetakSekarang');

// pembayaran service

Route::get('custpay', 'CustpayController@index');
Route::get('api.custpay', 'CustpayController@apiCustpay')->name('api.custpay');
Route::get('api.list_service', 'CustpayController@apiList')->name('api.list_service');
Route::get('pilih_service/{id}', 'CustpayController@pilihService');
Route::post('simpan_pembayaran_service', 'CustpayController@simpanPembayaran');
Route::post('hapus_pembayaran_service', 'CustpayController@hapusPembayaran');
Route::get('get_data_payment_service/{id}', 'CustpayController@getPayment');
Route::post('update_pembayaran_service', 'CustpayController@updatePembayaran');
Route::get('cetak_pembayaran_service/{id}/{invoice}', 'CustpayController@cetakPembayaran');
Route::get('report_ar_service', 'CustpayController@cetakLaporanPiutang');
Route::get('report_payment_service', 'CustpayController@cetakLaporanPembayaranService');
Route::get('arservice_cetak_sekarang/{customer?}', 'CustpayController@arServiceCetakSekarang');
Route::get('pembayaran_service/{customer?}', 'CustpayController@pembayaranService');


// penjualan

Route::get('sales', 'SaleController@index');
Route::get('api.sales', 'SaleController@apiSales')->name('api.sales');
Route::get('addsales','SaleController@addSales');
Route::get('select_sales_item/{id}','SaleController@selectBarang');
Route::get('sales.item', 'SaleController@salesItem')->name('sales.item');
Route::get('total_sales', 'SaleController@totalTransaksi');
Route::post('simpan_sales_item', 'SaleController@simpanSalesItem');
Route::post('item_sales_hapus', 'SaleController@hapusItem');
Route::get('edit_sales_item/{id}', 'SaleController@editSalesItem');
Route::post('update_sales_item', 'SaleController@updateSalesItem');
Route::get('list_harga_barang/{id}', 'SaleController@getHargaBarang');
Route::post('simpan_transaksi_sales', 'SaleController@simpanTransaksiSales');
Route::post('batal_penjualan', 'SaleController@batalPenjualan');
Route::post('hapus_penjualan', 'SaleController@hapusPenjualan');
Route::post('discount', 'SaleController@discountPenjualan');
Route::get('cetak_invoice_sales/{invoice}', 'SaleController@cetakInvoiceSales');
Route::get('edit_transaksi_sales/{invoice}', 'SaleController@editTransaksiSales');
Route::post('update_transaksi_sales', 'SaleController@updateTransaksiSales');
Route::get('lapsales', 'LaporanServiceController@salesReport');
Route::get('sales_report_cetak/{dari}/{sampai}/{pelanggan?}', 'LaporanServiceController@salesReportCetak');
Route::get('lapsalesproduk', 'LaporanServiceController@salesProduk');
Route::get('sales_produk_cetak/{dari}/{sampai}/{barang?}', 'LaporanServiceController@cetakSalesProduk');




//pembayaran penjualan

Route::get('salespay', 'SalespayController@index');
Route::get('api.salespay', 'SalespayController@apiSalespay')->name('api.salespay');
Route::get('api.list_sales', 'SalespayController@apiList')->name('api.list_sales');
Route::get('pilih_sales/{id}', 'SalespayController@pilihSales');
Route::post('simpan_pembayaran_sales', 'SalespayController@simpanPembayaran');
Route::post('hapus_pembayaran_sales', 'SalespayController@hapusPembayaran');
Route::get('get_data_payment_sales/{id}', 'SalespayController@getPayment');
Route::post('update_pembayaran_sales', 'SalespayController@updatePembayaran');
Route::get('cetak_pembayaran_sales/{id}/{invoice}', 'SalespayController@cetakPembayaran');
Route::get('report_ar_sales', 'SalespayController@cetakLaporanPiutang');
Route::get('report_payment_sales', 'SalespayController@cetakLaporanPembayaranSales');
Route::get('arsales_cetak_sekarang/{customer?}', 'SalespayController@arSalesCetakSekarang');
Route::get('pembayaran_sales/{customer?}', 'SalespayController@pembayaranSales');


// setting

Route::get('setting', 'SettingController@index'); 
Route::post('setting', 'SettingController@store');


Route::get('ploss', 'LaporanServiceController@ploss');
Route::get('ploss_cetak/{periode}', 'LaporanServiceController@plossPDF');


//quotation 

Route::get('quotation', 'QuoteController@index');
Route::get('api.quote', 'QuoteController@apiQuote')->name('api.quote');
Route::get('addQuote', 'QuoteController@addQuote');
Route::get('quote.item', 'QuoteController@quoteItem')->name('quote.item');
Route::post('simpan_quote_item', 'QuoteController@simpanQuoteItem');
Route::get('total_quote', 'QuoteController@totalTransaksi');
Route::post('item_quote_hapus', 'QuoteController@hapusItem');
Route::get('edit_quote_item/{id}', 'QuoteController@editQuoteItem');
Route::post('update_quote_item', 'QuoteController@updateQuoteItem');
Route::post('simpan_transaksi_quote', 'QuoteController@simpanTransaksiQuote');
Route::post('batal_quote', 'QuoteController@batalQuote');
Route::get('edit_quotation/{invoice}', 'QuoteController@editQuotation');
Route::post('update_transaksi_quote', 'QuoteController@updateTransaksiQuote');
Route::post('hapus_quotation', 'QuoteController@hapusQuotation');
Route::get('cetak_invoice_quotation/{invoice}', 'QuoteController@cetakInvoiceQuotation');


//Kas
Route::resource('cash', 'CashController');
Route::get('api.cash', 'CashController@apiCash')->name('api.cash');
Route::get('cetak_cash/{id}','CashController@cetakCash');
Route::get('cash_report', 'CashController@cashReport');
Route::get('cash_cetak_laporan/{dari}/{sampai}', 'CashController@laporanCash');


Route::get('flow','FlowController@index');
Route::get('print_flow/{dari}/{sampai}/{doc?}', 'FlowController@cetakFlow');


Route::resource('production', 'ProductionController');
Route::get('api.production', 'ProductionController@apiProduction')->name('api.production');
Route::get('addProduction', 'ProductionController@addProduction');
Route::get('caribrgproduksi/{brg}', 'ProductionController@cari');
Route::get('api.productionitem', 'ProductionController@apiItem')->name('api.productionitem');
Route::post('getbahanbaku', 'ProductionController@getBahan');
Route::post('simpan_item_produksi', 'ProductionController@simpanItemProduksi');
Route::post('simpan_produksi', 'ProductionController@simpanProduksi');
Route::get('cetak_produksi/{id}', 'ProductionController@cetakProduksi');
Route::delete('item_hapus_produksi/{id}', 'ProductionController@destroy');
Route::post('batal_produksi', 'ProductionController@batalProduksi');

Route::get('edit_produksi/{inv}', 'ProductionController@editProduksi');
Route::post('update_produksi', 'ProductionController@updateProduksi');
Route::delete('hapus_produksi', 'ProductionController@hapusProduksi');

Route::get('listproduksiantrian/{id}/{inv}', 'ProductionController@listproduksiantrian');
Route::post('adjust', 'ProductionController@adjust');
Route::post('updateadjust', 'ProductionController@updateadjust');

// GR

Route::get('gr', 'GRController@index');
Route::get('api.gr', 'GRController@apiGR')->name('api.gr');
Route::get('addGR', 'GRController@addGR');
Route::get('api.listpo', 'GRController@apiListPO')->name('api.listpo');
Route::post('pilihpurchaseorder', 'GRController@pilihPurchaseOrder');
Route::post('savegr', 'GRController@savedata');
Route::get('editgr/{grno}', 'GRController@editgr');
Route::post('updategr', 'GRController@updatedata');
Route::delete('deletegr', 'GRController@deletedata');
Route::get('printgr/{id}/{invoice}', 'GRController@printdata');


Route::post('cekitemproduksi', 'ProductionController@cekItemProduksi');
Route::get('cekcart', 'ProductionController@cekCart');



