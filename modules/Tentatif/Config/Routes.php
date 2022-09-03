<?php

/* 
    Define Tentatif Routes
*/
$routes->get('tentatif', '\Modules\Tentatif\Controllers\Tentatif::index');
$routes->post('tentatif/tambah', '\Modules\Tentatif\Controllers\Tentatif::add');
