<?php

/* 
    Define Krs Routes
*/
$routes->get('blok', '\Modules\Blok\Controllers\Blok::index');
$routes->post('blok/tambah', '\Modules\Blok\Controllers\Blok::add');
