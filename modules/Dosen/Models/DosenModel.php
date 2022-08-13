<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'dosenId';
    protected $allowedFields = ['dosenFullname', 'dosenShortname', 'dosenEmailCorporate', 'dosenEmailGeneral', 'dosenPhone', 'dosenStatus'];
    protected $returnType = 'object';

    public function getDataDosen($keyword = null)
    {
        $builder = $this->table('dosen');
        if ($keyword) {
            $builder->like('dosen.dosenFullname', $keyword);
            $builder->orlike('dosen.dosenShortname', $keyword);
            $builder->orlike('dosen.dosenEmail', $keyword);
            $builder->orlike('dosen.dosenPhone', $keyword);
        }
        $builder->orderBy('dosen.dosenId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('dosen');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
