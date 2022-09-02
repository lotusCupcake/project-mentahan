<?php

namespace Modules\Sesi\Models;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'sesiId';
    protected $allowedFields = ['sesiJenisJadwalId', 'sesiNama', 'sesiStart', 'sesiEnd'];
    protected $returnType = 'object';

    public function getSesiJadwal($keyword = null)
    {
        $builder = $this->table('sesi');
        $builder->join('jenis_jadwal', 'jenis_jadwal.jenisJadwalId = sesi.sesiJenisJadwalId', 'LEFT');
        $builder->whereNotIn('jenis_jadwal.jenisJadwalId', ['3']);
        if ($keyword) {
            $builder->like('jenis_jadwal.jenisJadwalNama', $keyword);
            $builder->orlike('sesi.sesiNama', $keyword);
        }
        $builder->groupBy('sesi.sesiJenisJadwalId');
        return $builder;
    }

    public function getSesi()
    {
        $builder = $this->table($this->table);
        $builder->join('jenis_jadwal', 'jenis_jadwal.jenisJadwalId = sesi.sesiJenisJadwalId', 'LEFT');
        return $builder;
    }

    public function getSesiWhere($where)
    {
        $builder = $this->table($this->table);
        $builder->where($where);
        return $builder;
    }
}
