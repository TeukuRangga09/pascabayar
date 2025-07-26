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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'landing';
$route['login'] = 'frontend/autentifikasi/login';
$route['register'] = 'frontend/autentifikasi/register';
$route['logout'] = 'frontend/autentifikasi/logout';

$route['cek_tagihan/p'] = 'frontend/cek_tagihan_pelanggan';
$route['cek_tagihan/p/bayar/(:num)'] = 'frontend/cek_tagihan_pelanggan/bayar/$1';
$route['cek_tagihan/p/proses_pembayaran'] = 'frontend/cek_tagihan_pelanggan/proses_pembayaran';

$route['riwayat_penggunaan'] = 'frontend/riwayat_penggunaan';
$route['riwayat_pembayaran'] = 'frontend/riwayat_pembayaran';
$route['riwayat_pembayaran/struk/(:any)'] = 'frontend/riwayat_pembayaran/cetak_struk/$1';

$route['profil'] = 'frontend/profil';
$route['tarif'] = 'frontend/tarif_listrik';
$route['kontak'] = 'frontend/kontak_kami';

$route['cek_tagihan/g'] = 'frontend/cek_tagihan_guest';
$route['cek_tagihan/g/hasil'] = 'frontend/cek_tagihan_guest/hasil';

$route['backend'] = 'backend/autentifikasi_backend/login';
$route['backend/login'] = 'backend/autentifikasi_backend/login';
$route['backend/proses_login'] = 'backend/autentifikasi_backend/proses_login';
$route['backend/logout'] = 'backend/autentifikasi_backend/proses_logout';

$route['backend/dashboard'] = 'backend/dashboard_backend';
$route['backend/level_pengguna'] = 'backend/level_pengguna_backend';
$route['backend/kelola_pengguna'] = 'backend/kelola_pengguna_backend';
$route['backend/tarif'] = 'backend/tarif_listrik_backend/tarif';
$route['backend/pelanggan'] = 'backend/pelanggan_backend';
$route['backend/penggunaan'] = 'backend/Penggunaan_backend';

$route['backend/tagihan'] = 'backend/Tagihan_backend';
// $route['backend/tagihan/verifikasi/(:num)/(:any)'] = 'backend/Tagihan_Backend/verifikasi/$1/$2';
$route['backend/tagihan/verifikasi/(:num)/(:any)/(:any)'] = 'backend/Tagihan_Backend/verifikasi/$1/$2/$3';


$route['backend/pembayaran'] = 'backend/Pembayaran_backend';
$route['backend/pengaturan_akun'] = 'backend/Pengaturan_Akun_Backend';


$route['404_override'] = 'errors/page_missing';
$route['translate_uri_dashes'] = FALSE;
