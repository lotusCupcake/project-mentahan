<?php

/* 
    Define Krs Routes
*/
$routes->get('dosen', '\Modules\Dosen\Controllers\Dosen::index');
$routes->post('dosen/tambah/internal', '\Modules\Dosen\Controllers\Dosen::add');
$routes->post('dosen/tambah/eksternal', '\Modules\Dosen\Controllers\Dosen::add');
$routes->add('dosen/ubah/(:num)', '\Modules\Dosen\Controllers\Dosen::edit/$1');
$routes->delete('dosen/hapus/(:num)', '\Modules\Dosen\Controllers\Dosen::delete/$1');
$routes->post('/dosen/load', '\Modules\Dosen\Controllers\Dosen::loadDosenJadwal');
$routes->get('/dosen/batal', '\Modules\Dosen\Controllers\Dosen::abort');
$routes->post('/dosen/simpan', '\Modules\Dosen\Controllers\Dosen::save');
$routes->post('/dosen/loadEdit', '\Modules\Dosen\Controllers\Dosen::loadDosenJadwalEdit');
