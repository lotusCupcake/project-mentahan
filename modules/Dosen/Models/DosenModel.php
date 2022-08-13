<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'dosenId';
    protected $allowedFields = ['dosenFullname', 'dosenShortname', 'dosenEmailCorporate', 'dosenEmailGeneral', 'dosenPhone'];
    protected $returnType = 'object';

    public function getDosen($keyword = null)
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

    public function getDosenJadwal($sesi, $tgl)
    {
        $builder = $this->db->query("CALL loadDosenJadwal(" . $sesi . ",'" . $tgl . "')");
        return $builder;
    }
}
