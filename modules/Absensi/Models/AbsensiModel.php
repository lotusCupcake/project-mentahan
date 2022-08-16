<?php

namespace Modules\Absensi\Models;

use CodeIgniter\Model;

class AbsensiModel extends Model
{
    protected $table = 'absensi';
    protected $primaryKey = 'absensiId';
    protected $allowedFields = ['absensiMatkulBlokId'];
    protected $returnType = 'object';
}
