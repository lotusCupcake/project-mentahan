<?php

namespace Modules\Blok\Models;

use CodeIgniter\Model;

class BlokModel extends Model
{
    protected $table = 'matkul_blok';
    protected $primaryKey = 'matkulBlokId';
    protected $allowedFields = ['matkulBlokNama', 'matkulBlokProdiNama'];
    protected $returnType = 'object';

    public function getMatkulBlok($keyword = null)
    {
        $builder = $this->table('matkul_blok');
        $builder->where('matkulBlokType', 'BLOK');
        if ($keyword) {
            $builder->orlike('matkul_blok.matkulBlokNama', $keyword);
            $builder->orlike('matkul_blok.matkulBlokProdiNama', $keyword);
        }
        $builder->orderBy('matkul_blok.matkulBlokId', 'DESC');
        return $builder;
    }

    public function dataExist($where)
    {
        $builder = $this->table('matkul_blok');
        $builder->where($where);
        $query = $builder->countAllResults();
        return $query;
    }
}
