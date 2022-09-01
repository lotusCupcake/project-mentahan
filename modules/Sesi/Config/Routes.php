<?php

/* 
    Define Krs Routes
*/
$routes->get('sesi', '\Modules\Sesi\Controllers\Sesi::index');
$routes->post('sesi/getSesi', '\Modules\Sesi\Controllers\Sesi::getSesi');
