<?php

/* 
    Define Krs Routes
*/
$routes->get('home', '\Modules\Home\Controllers\Home::index');
$routes->get('home/add', '\Modules\Home\Controllers\Home::addCalendar');
$routes->get('home/del', '\Modules\Home\Controllers\Home::delCalendar');
$routes->get('home/edit', '\Modules\Home\Controllers\Home::editCalendar');
$routes->get('home/list', '\Modules\Home\Controllers\Home::listCalendar');
$routes->get('home/col', '\Modules\Home\Controllers\Home::colorCalendar');
