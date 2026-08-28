<?php

namespace App\Controllers;

class Prueba extends BaseController
{
    public function index(): string
    {
        
            //echo "Hola " ;

            $datos['numero'] = "Jhostyn Tobar";
            $datos['direccion'] = "Ibarra";
            
            return view('prueba/index', $datos);
    
    }

   
}
