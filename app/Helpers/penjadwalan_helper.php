<?php

function getPeserta($id)
{
    $penjadwalan = new \Modules\Penjadwalan\Models\PenjadwalanModel;
    $peserta = $penjadwalan->where(['penjadwalanId' => $id])->findAll()[0]->penjadwalanPeserta;
    return $peserta;
}

function randomColor()
{
    $color = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
    return $color[random_int(1, 5)];
}
