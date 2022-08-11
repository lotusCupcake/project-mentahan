<?php

/* 
This is Controller Krs
 */

namespace Modules\Blok\Controllers;

use App\Controllers\BaseController;
use Modules\Blok\Models\BlokModel;

class Blok extends BaseController
{

    protected $blokModel;

    public function __construct()
    {
        $this->blokModel = new BlokModel();
    }
    public function index()
    {
        $data = [
            'menu' => $this->fetchMenu(),
            'title' => "Blok",
            'breadcrumb' => ['Data', 'Blok'],
            'matkulBlok' => $this->blokModel->getBlok(),
        ];
        dd($data['matkulBlok']);
        return view('Modules\Blok\Views\blok', $data);
    }
}
