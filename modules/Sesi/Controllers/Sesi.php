<?php

/* 
This is Controller Krs
 */

namespace Modules\Sesi\Controllers;

use App\Controllers\BaseController;
use Modules\Sesi\Models\SesiModel;


class Sesi extends BaseController
{

    public function __construct()
    {
        $this->sesi = new SesiModel();
    }

    public function index()
    {
        $data = [
            'title' => '<iframe src="https://calendar.google.com/calendar/embed?src=oc9jbs14jprou74o5im5isjq3s%40group.calendar.google.com&ctz=Asia%2FJakarta" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>',
            'breadcrumb' => ['Home', 'Sesi'],
        ];
        return view('Modules\Sesi\Views\sesi', $data);
    }

    public function getSesi()
    {
        $jenisJadwal = $this->request->getVar('id');
        $where = ['sesiJenisJadwalId' => $jenisJadwal];
        echo json_encode($this->sesi->getSesi($where)->findAll());
    }
}
