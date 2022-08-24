<?php

namespace Modules\Absensi\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensiId';
    protected $allowedFields = ['absensiAngkatan', 'absensiMatkulBlokId', 'absensiTahunAjaran', 'absensiPeserta', 'absensiCreatedBy', 'absensiCreatedDate', 'absensiModifiedBy', 'absensiModifiedDate'];
    protected $useTimestamps = 'false';
    protected $createdField = 'absensiCreatedDate';
    protected $updatedField = 'absensiModifiedDate';
    protected $returnType = 'object';

    public function getAbsen($keyword = null)
    {
        $builder = $this->table('absensi');
        $builder->join('matkul_blok', 'matkul_blok.matkulBlokId = absensi.absensiMatkulBlokId');
        if ($keyword) {
            $builder->orlike('absensi.absensiTahunAjaran', $keyword);
            $builder->orlike('matkul_blok.matkulBlokNama', $keyword);
            $builder->orlike('absensi.absensiAngkatan', $keyword);
        }
        $builder->orderBy('absensi.absensiId', 'DESC');
        return $builder;
    }
}
