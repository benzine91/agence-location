<?php 

namespace App\Service;

class NameFile
{
    public function renamefile($file)
    {
     $valus = date('YmdHis') . "-" . uniqid() . "-" . rand(10000, 999999) . "." . $file->getClientOriginalExtension();
     return $valus;
    }
}
