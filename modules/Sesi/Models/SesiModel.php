<?php

namespace Modules\Sesi\Models;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'sesiId';
    protected $allowedFields = ['sesiNama', 'sesiStart', 'sesiEnd'];
    protected $returnType = 'object';

    public function getSesi($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }
}
