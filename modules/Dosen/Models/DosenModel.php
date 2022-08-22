<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'dosenId';
    protected $allowedFields = ['dosenSimakadId', 'dosenFullname', 'dosenShortname', 'dosenEmailCorporate', 'dosenEmailGeneral', 'dosenPhone', 'dosenStatus'];
    protected $returnType = 'object';

    public function getDataDosen($keyword = null)
    {
        $builder = $this->table('dosen');
        if ($keyword) {
            $builder->like('dosen.dosenFullname', $keyword);
            $builder->orlike('dosen.dosenShortname', $keyword);
            $builder->orlike('dosen.dosenEmailCorporate', $keyword);
            $builder->orlike('dosen.dosenEmailGeneral', $keyword);
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

    public function cekDosen($where)
    {
        $builder = $this->table('dosen');
        $builder->where($where);
        return $builder;
    }

    public function getDosenJadwal($sesi, $tgl)
    {
        $builder = $this->db->query("CALL loadDosenJadwal(" . $sesi . ",'" . $tgl . "')");
        return $builder;
    }
    public function getDosenJadwalEdit($data)
    {
        $builder = $this->db->query("CALL loadDosenJadwalEdit(" . $data[0] . ",'" . $data[1] . "'," . $data[2] . ",'" . $data[3] . "'," . $data[4] . "," . $data[5] . ")");
        return $builder;
    }
}
