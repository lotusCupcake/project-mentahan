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

function decryptPeserta($peserta)
{
    $result = [];
    foreach (json_decode($peserta)->data as $key => $value) {
        $result[] = $value->email;
    }
    return $result;
}


function getTahunAjaran()
{
    $tahunAjaran = new \App\Models\ApiModel;
    $response = $tahunAjaran->getTahunAjaran();
    return $response;
}

function getListTahunAjaran()
{
    $tahunAjaran = new \App\Models\ApiModel;
    $response = $tahunAjaran->getListTahunAjaran();
    return $response;
}

function getDosenName($email)
{
    $dosen = new \Modules\Dosen\Models\DosenModel;
    $fullName = $dosen->where(['dosenEmailGeneral' => $email])->findAll()[0]->dosenFullname;
    return $fullName;
}

function getSpecificUser($where)
{
    $manajemen = new \Modules\ManajemenAkun\Models\ManajemenAkunModel;
    $result = $manajemen->getSpecificUser($where)->getResult()[0];
    return $result;
}

// function getJadwalWhere($where)
// {
//     $jadwal = new \Modules\JenisJadwal\Models\JenisJadwalModel;
//     $result = $jadwal->getJadwalWhere($where)->findAll();
//     return $result;
// }

function getSesiWhere($where)
{
    $sesi = new \Modules\Sesi\Models\SesiModel;
    $result = $sesi->getSesiWhere($where)->findAll();
    return $result;
}
