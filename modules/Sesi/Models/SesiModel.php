<?php

namespace Modules\Sesi\Models;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'sesiId';
    protected $allowedFields = ['sesiJenisJadwalId', 'sesiNama', 'sesiStart', 'sesiEnd', 'sesiCreatedBy', 'sesiCreatedDate', 'sesiModifiedBy', 'sesiModifiedDate', 'sesiDeletedDate'];
    protected $useTimestamps = 'false';
    protected $useSoftDeletes = 'true';
    protected $createdField = 'sesiCreatedDate';
    protected $updatedField = 'sesiModifiedDate';
    protected $deletedField = 'sesiDeletedDate';
    protected $returnType = 'object';

    public function getSesiJadwal($keyword = null, $jenis = null)
    {
        $builder = $this->table('sesi');
        $builder->join('jenis_jadwal', 'jenis_jadwal.jenisJadwalId = sesi.sesiJenisJadwalId', 'LEFT');
        if ($jenis) {
            $builder->whereIn('jenis_jadwal.jenisJadwalId', $jenis);
        }
        $builder->whereNotIn('jenis_jadwal.jenisJadwalId', ['3']);
        if ($keyword) {
            $builder->like('jenis_jadwal.jenisJadwalNama', $keyword)->where('sesi.sesiDeletedDate', 'null');
            $builder->orlike('sesi.sesiNama', $keyword)->where('sesi.sesiDeletedDate', 'null');
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
        $builder->join('jenis_jadwal', 'jenis_jadwal.jenisJadwalId =' . $this->table . '.sesiJenisJadwalId', 'LEFT');
        $builder->where($where);
        return $builder;
    }
}
