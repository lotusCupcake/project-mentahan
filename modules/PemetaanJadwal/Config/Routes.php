<?php

/* 
    Define PemetaanJadwal Routes
*/
$routes->get('pemetaanJadwal', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::index');
$routes->post('pemetaanJadwal/cetak', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::test');
