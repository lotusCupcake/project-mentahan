<?php

namespace Modules\Blok\Models;

use CodeIgniter\Model;

class BlokModel extends Model
{
    protected $table = 'matkul_blok';
    protected $primaryKey = 'matkulBlokId';
    protected $allowedFields = ['matkulBlokNama', 'matkulBlokProdiNama', 'matkulBlokType'];
    protected $returnType = 'object';

    public function getMatkulBlok($keyword = null, $tipe = null)
    {
        $builder = $this->table('matkul_blok');
        if ($tipe) {
            $builder->where('matkul_blok.matkulBlokType', $tipe);
        }
        if ($keyword) {
            $builder->orlike('matkul_blok.matkulBlokNama', $keyword);
            $builder->orlike('matkul_blok.matkulBlokProdiNama', $keyword);
            $builder->orlike('matkul_blok.matkulBlokType', $keyword);
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
