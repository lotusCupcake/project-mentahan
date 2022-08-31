<?php

namespace Modules\Sesi\Models;

use CodeIgniter\Model;

class SesiModel extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'sesiId';
    protected $allowedFields = ['sesiJenisJadwalId', 'sesiDetail'];
    protected $returnType = 'object';
}
