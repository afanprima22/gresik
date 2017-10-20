<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = 'Page_404';
$route['translate_uri_dashes'] = FALSE;

$route['Page-Unauthorized']										= 'Page_403';
$route['Setup-Data/Wilayah']									= 'City';
$route['Setup-Data/Division']									= 'Division';
$route['Setup-Data/Gudang']										= 'Warehouse';
$route['Setup-Data/Mesin']										= 'Machine';
$route['Setup-Data/Kendaraan']									= 'Vehicle';
$route['Setup-Data/Onderdil']									= 'Sperpart';
$route['Setup-Data/Type-Material']								= 'Material_type';
$route['Setup-Data/Lokasi']										= 'Location';
$route['Master-Data/Bahan-Material']							= 'Material';
$route['Master-Data/Customer']									= 'Customer';
$route['Master-Data/Sopir-Kernet']								= 'Operator';
$route['Master-Data/Sales']										= 'Sales';
$route['Master-Data/Partner']									= 'Partner';
$route['Master-Data/Karyawan']									= 'Employee';
$route['Master-Data/Bahan-Paket']								= 'Package';
$route['Master-Data/Barang-Jadi']								= 'Item';
$route['Master-Data/Barang-Setengah-Jadi']						= 'Item_half';
$route['Master-Data/Promo']										= 'Discount';
$route['Master-Data/Forecast']									= 'Forecast';
$route['Master-Data/Bonus-Barang']								= 'Item_discount';
$route['Master-Data/Spg']										= 'Spg';
$route['Master-Data/Kongsi']									= 'Kongsi';
$route['Setting/Type-User']										= 'User_type';
$route['Setting/User']											= 'User';
$route['Setting/Password-Request']								= 'Keyword';
$route['Transaction/Service/Mesin']								= 'Service_macine';
$route['Transaction/Service/Kendaraan']							= 'Service_vehicle';
$route['Transaction/Mixer']										= 'Mixer';
$route['Transaction/Produksi']									= 'Production';
$route['Transaction/ProduksiV2']								= 'Production_v2';
$route['Transaction/Memo']										= 'Memo';
$route['Transaction/Packaging']									= 'Packaging';
$route['Transaction/Nota']										= 'Nota';
$route['Transaction/Pengiriman']								= 'Delivery';
$route['Transaction/Nota/Nota-Retail']							= 'Nota_retail';
$route['Transaction/Nota/Nota-Pajak']							= 'Nota_tax';
$route['Transaction/Penggilingan']								= 'Milling';
$route['Transaction/Pembelian/Barang']							= 'Purchase_item';
$route['Transaction/Pembelian/Sperpart']						= 'Purchase_sperpart';
$route['Transaction/Pembelian/Material']						= 'Purchase_material';
$route['Transaction/Penerimaan']								= 'Receipt';
$route['Transaction/Retur/Customer']							= 'Retur_cus';
$route['Transaction/Order-Production']							= 'Order_production';
$route['Transaction/Penerimaan-Packaging-Box']					= 'Recept_packaging';
$route['Transaction/Penerimaan-Packaging-Retail']				= 'Recept_packaging_retail';
$route['Transaction/Order-Kongsi']								= 'Order_kongsi';
$route['Transaction/Set-Kongsi']								= 'Set_branch_kongsi';
$route['Transaction/Invoice-Kongsi']							= 'Invoice_kongsi';
//Laporan
$route['Laporan/Spg']											= 'Report_Spg';