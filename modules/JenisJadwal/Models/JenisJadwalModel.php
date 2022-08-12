<?php

namespace Modules\JenisJadwal\Models;

use CodeIgniter\Model;

class JenisJadwalModel extends Model
{
    protected $table = 'jenis_jadwal';
    protected $primaryKey = 'jenisJadwalId';
    protected $allowedFields = ['jenisJadwalKode', 'jenisJadwalNama', 'jenisJadwalIsAktif'];
    protected $returnType = 'object';
}
