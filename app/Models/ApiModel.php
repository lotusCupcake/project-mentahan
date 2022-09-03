<?php

namespace App\Models;

use CodeIgniter\Model;

class ApiModel extends Model
{
    protected $curl;

    public function __construct()
    {
        $this->curl = service('curlrequest');
    }

    public function getBlok()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/DigiSched/matkulBlokFk", [
            "headers" => [
                "Accept" => "application/json"
            ],
        ]);
        return json_decode($response->getBody())->data;
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

    public function getTahunAjaran()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/digiSched/getTahunAkademik", [
            "headers" => [
                "Accept" => "application/json"
            ],

        ]);

        return json_decode($response->getBody())->data;
    }

    public function getListTahunAjaran()
    {
        $response = $this->curl->request("GET", "https://api.umsu.ac.id/digiSched/getTahunAjaran", [
            "headers" => [
                "Accept" => "application/json"
            ],

        ]);

        return json_decode($response->getBody())->data;
    }
}
