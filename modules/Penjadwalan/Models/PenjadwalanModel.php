<?php

namespace Modules\Penjadwalan\Models;

use CodeIgniter\Model;

class PenjadwalanModel extends Model
{
    protected $table = 'penjadwalan';
    protected $primaryKey = 'penjadwalanId';
    protected $allowedFields = [
        'penjadwalanJenisJadwalId', 'penjadwalanMatkulBlokId', 'penjadwalanSesiId', 'penjadwalanCalenderId', 'penjadwalanJudul', 'penjadwalanDeskripsi', 'penjadwalanLokasi',
        'penjadwalanColorId', 'penjadwalanStartDate', 'penjadwalanEndDate', 'penjadwalanPeserta', 'penjadwalanNotes', 'penjadwalanJudulShow', 'penjadwalanAngkatan'
    ];
    protected $returnType = 'object';

    public function getPenjadwalan($keyword = null)
    {
        $builder = $this->table($this->table);
        $builder->join('jenis_jadwal', 'jenis_jadwal.jenisJadwalId = ' . $this->table . '.penjadwalanJenisJadwalId', 'LEFT');
        $builder->join('matkul_blok', 'matkul_blok.matkulBlokId = ' . $this->table . '.penjadwalanMatkulBlokId', 'LEFT');
        $builder->join('sesi', 'sesi.sesiId = ' . $this->table . '.penjadwalanSesiId', 'LEFT');
        if ($keyword) {
            $builder->like($this->table . '.penjadwalanJudul', $keyword);
            $builder->like('matkul_blok.matkulBlokKode', $keyword);
            $builder->like('matkul_blok.matkulBlokNama', $keyword);
            $builder->like('sesi.sesiNama', $keyword);
        }
        $builder->orderBy($this->primaryKey, 'DESC');
        return $builder;
    }
}
