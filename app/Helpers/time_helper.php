<?php

function timeGoogleToAppLong($string)
{
    $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
    $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $time = date($string);
    $hari = $hari[date('N', strtotime($time)) - 1];
    $bulan = $bulan[date('n', strtotime($time)) - 1];
    $date = $hari . ', ' . date('d', strtotime($time)) . ' ' . $bulan . date(' Y h:i:s T', strtotime($time));
    dd($date);
}

function timeGoogleToAppShort($string)
{
    $time = date($string);
    $date = date('Y-m-d h:i:s ', strtotime($time));
    dd($date);
}

function timeAppToGoogle($string)
{
    $time = date($string);
    $date = date('Y-m-d\TH:i:sP', strtotime($time));
    dd($date);
}
