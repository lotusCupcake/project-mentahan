<?php

namespace Modules\JenisJadwal\Models;

use CodeIgniter\Model;

class JenisJadwalModel extends Model
{
    protected $table = 'jenis_jadwal';
    protected $primaryKey = 'jenisJadwalId';
    protected $allowedFields = ['jenisJadwalKode', 'jenisJadwalNama', 'jenisJadwalIsAktif'];
    protected $returnType = 'object';

    public function getJenisJadwal($jenis = null)
    {
        $builder = $this->table($this->table);
        if ($jenis) {
            $builder->whereIn('jenis_jadwal.jenisJadwalId', $jenis);
        }
        $builder->where('jenis_jadwal.jenisJadwalIsAktif', 1);
        return $builder;
    }

    public function getTentatif()
    {
        $union = $this->db->table($this->table)->select(["jenisJadwalId", "CONCAT (jenisJadwalKode, '1') AS unic", "CONCAT (jenisJadwalKode, ' Offline') AS jenisJadwalKode"])->where('jenisJadwalIsTentatif', 1);
        $builder = $this->db->table($this->table)->select(["jenisJadwalId", "CONCAT (jenisJadwalKode, '0') AS unic", "CONCAT (jenisJadwalKode, ' Online') AS jenisJadwalKode"])->where('jenisJadwalIsTentatif', 1)->where('jenisJadwalAvailOl', 1);
        return $builder->union($union);
    }

    public function getJadwalTentatif()
    {
        $builder = $this->table($this->table);
        $builder->where([$this->table . 'jenisJadwalIsTentatif' => 1, $this->table . 'jenisJadwalIsAktif' => 1]);
    }
}
