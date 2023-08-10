<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Dashboard extends BaseController
{
    protected $user;
    public function __construct()
    {
        $this->user = new LoginModel();
    }
    public function index()
    {
        $this->Access(['admin']);
        $db = \Config\Database::connect();
        //count data training
        $queryTrain = $db->table('data_training');
        $counTrain = $queryTrain->countAllResults();
        //count data testing
        $queryTest = $db->table('data_testing');
        $counTest = $queryTest->countAllResults();
        //count label layak
        $queryLayak = $db->table('data_training');
        $queryLayak->where('label', 'Layak');
        $countLayak = $queryLayak->countAllResults();
        //count label tidak layak
        $queryTidak = $db->table('data_training');
        $queryTidak->where('label', 'Tidak Layak');
        $counTidak = $queryTidak->countAllResults();

        $data = [
            'train' => $counTrain,
            'test' => $counTest,
            'layak' => $countLayak,
            'tidak' => $counTidak
        ];
        return view('Admin/dashboard', $data);
    }
}
