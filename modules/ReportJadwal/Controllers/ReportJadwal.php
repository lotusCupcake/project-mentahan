<?php

/* 
This is Controller Krs
 */

namespace Modules\ReportJadwal\Controllers;

use App\Controllers\BaseController;
use Modules\ReportJadwal\Models\ReportJadwalModel;
use App\Models\ApiModel;

class ReportJadwal extends BaseController
{

    protected $reportJadwalModel;
    protected $apiModel;

    public function __construct()
    {
        $this->reportJadwalModel = new ReportJadwalModel();
        $this->apiModel = new ApiModel();
    }

    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Report Jadwal",
            'breadcrumb' => ['Proses', 'Report Jadwal'],
            'validation' => \Config\Services::validation(),
        ];
        return view('Modules\ReportJadwal\Views\reportJadwal', $data);
    }
}
