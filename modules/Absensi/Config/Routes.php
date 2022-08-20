<?php

/* 
    Define Krs Routes
*/
$routes->get('absensi', '\Modules\Absensi\Controllers\Absensi::index');
$routes->post('absensi/tambah', '\Modules\Absensi\Controllers\Absensi::add');
$routes->put('absensi/ubah/(:num)', '\Modules\Absensi\Controllers\Absensi::edit/$1');
$routes->delete('absensi/hapus/(:num)', '\Modules\Absensi\Controllers\Absensi::delete/$1');
