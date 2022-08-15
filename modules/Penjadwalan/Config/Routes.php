<?php

/* 
    Define Krs Routes
*/
$routes->get('penjadwalan', '\Modules\Penjadwalan\Controllers\Penjadwalan::index');
$routes->post('penjadwalan/add', '\Modules\Penjadwalan\Controllers\Penjadwalan::penjadwalanAdd');
$routes->get('penjadwalan/event', '\Modules\Penjadwalan\Controllers\Penjadwalan::loadData');
$routes->post('penjadwalan/eventAjax', '\Modules\Penjadwalan\Controllers\Penjadwalan::ajax');
