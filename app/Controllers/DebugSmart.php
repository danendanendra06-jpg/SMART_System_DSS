<?php
namespace App\Controllers;

class DebugSmart extends BaseController
{
    public function index()
    {
        $smart = new Smart();
        $ref = new \ReflectionClass($smart);
        
        $method = $ref->getMethod('getUtilityData');
        $method->setAccessible(true);
        $data = $method->invoke($smart, 'global');
        
        echo "Utility:\n";
        print_r($data['utility']);
        
        $methodBobot = $ref->getMethod('getUserBobot');
        $methodBobot->setAccessible(true);
        $bobot = $methodBobot->invoke($smart, 'global');
        
        echo "\nBobot:\n";
        print_r($bobot);
    }
}
