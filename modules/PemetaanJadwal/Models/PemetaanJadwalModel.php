<?php

namespace Modules\PemetaanJadwal\Models;

use CodeIgniter\Model;

class PemetaanJadwalModel extends Model
{
    protected $table = 'jadwal_tentatif';
    protected $primaryKey = 'jadwalTentatifId';
    protected $allowedFields = ['jadwalTentatifTahunAjaran', 'jadwalTentatifDosenId', 'jadwalTentatifDetail'];
    protected $returnType = 'object';

    public function dataExist($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }
}
