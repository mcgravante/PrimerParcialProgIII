<?php
class Datos
{
    public static function getJSON($archivo)
    {
        $file = fopen($archivo, 'a+');
        if(filesize($archivo)!=0)
        {
            $arrayString = fread($file, filesize($archivo));
            $arrayJSON = json_decode($arrayString);
            fclose($file);
            return $arrayJSON;
        }else{
            fclose($file);
            return NULL;
        }
    }

    public static function guardarJSON($archivo, $objeto)
    {
        $arrayJson= Datos::getJSON($archivo);
        if (is_null($arrayJson))
        {
            $arrayJson = array();
        }
        array_push($arrayJson, $objeto);
        $file = fopen($archivo, 'w');
        $rta = fwrite($file, json_encode($arrayJson));
        fclose($file);
        return $rta;
    }
}