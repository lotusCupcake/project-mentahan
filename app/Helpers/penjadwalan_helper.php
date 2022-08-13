<?php

function getPeserta($id)
{
    $penjadwalan = new \Modules\Penjadwalan\Models\PenjadwalanModel;
    $peserta = $penjadwalan->where(['penjadwalanId' => $id])->findAll()[0]->penjadwalanPeserta;
    return $peserta;
}
