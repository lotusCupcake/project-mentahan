<?php

/* 
    Define Krs Routes
*/
$routes->get('dosen', '\Modules\Dosen\Controllers\Dosen::index');
$routes->post('dosen/tambah', '\Modules\Dosen\Controllers\Dosen::add');
$routes->delete('dosen/hapus/(:num)', '\Modules\Dosen\Controllers\Dosen::delete/$1');
