<?php

namespace Modules\Dosen\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $curl;
    public function __construct()
    {
        $this->curl = service('curlrequest');
    }

    public function getDosen()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/DigiSched/dosenfk", [
            "headers" => [
                "Accept" => "application/json"
            ],
        ]);
        return json_decode($response->getBody())->data;
    }
}
