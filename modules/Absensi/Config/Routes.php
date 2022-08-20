<?php

/* 
    Define Krs Routes
*/
$routes->get('absensi', '\Modules\Absensi\Controllers\Absensi::index');
$routes->post('absensi/tambah', '\Modules\Absensi\Controllers\Absensi::add');
