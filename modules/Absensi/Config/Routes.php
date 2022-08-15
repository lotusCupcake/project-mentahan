<?php

/* 
    Define Krs Routes
*/
$routes->get('absensi', '\Modules\Absensi\Controllers\Absensi::index');
$routes->post('absensi/unggah', '\Modules\Absensi\Controllers\Absensi::upload');
