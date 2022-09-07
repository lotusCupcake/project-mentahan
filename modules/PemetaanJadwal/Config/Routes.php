<?php

/* 
    Define PemetaanJadwal Routes
*/
$routes->get('pemetaanJadwal', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::index');
$routes->get('pemetaanJadwal/cetak', '\Modules\PemetaanJadwal\Controllers\PemetaanJadwal::testExcel');
