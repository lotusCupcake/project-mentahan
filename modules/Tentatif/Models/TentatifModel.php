<?php

namespace Modules\Tentatif\Models;

use CodeIgniter\Model;

class TentatifModel extends Model
{
    protected $table = 'jadwal_tentatif';
    protected $primaryKey = 'jadwalTentatifId';
    protected $allowedFields = ['jadwalTentatifTahunAjaran', 'jadwalTentatifDosenId', 'jadwalTentatifDetail'];
    protected $useTimestamps = 'false';
    protected $createdField = 'jadwalTentatifCreatedDate';
    protected $updatedField = 'jadwalTentatifModifiedDate';
    protected $returnType = 'object';

    public function dataExist($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }
}
