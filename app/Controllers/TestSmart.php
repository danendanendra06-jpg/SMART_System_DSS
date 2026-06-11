<?php

namespace App\Controllers;

class TestSmart extends BaseController
{
    public function index()
    {
        $smart = new Smart();
        
        $ref = new \ReflectionClass($smart);
        $getUtilityData = $ref->getMethod('getUtilityData');
        $getUtilityData->setAccessible(true);
        $utilityData = $getUtilityData->invoke($smart, 'global');
        
        $getUserBobot = $ref->getMethod('getUserBobot');
        $getUserBobot->setAccessible(true);
        $kriteria = $getUserBobot->invoke($smart, 'global');
        
        $totalBobot = 0;
        foreach ($kriteria as $k) {
            $totalBobot += $k['bobot'];
        }
        
        return $this->response->setJSON([
            'kriteria' => $kriteria,
            'totalBobot' => $totalBobot,
            'utilityData' => $utilityData
        ]);
    }
}
