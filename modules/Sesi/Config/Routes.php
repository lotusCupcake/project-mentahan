<?php

/* 
    Define Sesi Routes
*/
$routes->get('sesi', '\Modules\Sesi\Controllers\Sesi::index');
$routes->post('sesi/tambah', '\Modules\Sesi\Controllers\Sesi::add');
$routes->put('sesi/ubah/(:num)', '\Modules\Sesi\Controllers\Sesi::edit/$1');
$routes->delete('sesi/hapus/(:num)', '\Modules\Sesi\Controllers\Sesi::delete/$1');
