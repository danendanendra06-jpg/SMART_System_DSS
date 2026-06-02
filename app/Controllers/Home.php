<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard | SPK SMART'
        ];
        return view('home/index', $data);
    }
}
