<?php

/* 
    Define PemetaanJadwal Routes
*/
$routes->get('pemetaanJadwal', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::index');
$routes->post('pemetaanJadwal/tambah', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::add');
