<?php
class Profesor
{
    const ARCHIVO = "profesores.json";
    public $nombre;
    public $legajo;
    public $imagen;

    public function __construct($nombre, $legajo, $imagen)
    {
        $this->nombre = $nombre;
        $this->legajo = $legajo;
        $this->imagen=$imagen;
    }

    public static function Save($nombre, $legajo, $imagen)
     {
        $return=false;
        $profesor = new Profesor($nombre, $legajo, $imagen);
        $lista = Datos::getJson(self::ARCHIVO);
        if (Profesor::ProfesorAlreadyExists($profesor))
        {
            $return = "Legajo existente";
        }else
        {
            if (Datos::GuardarJSON(self::ARCHIVO,$profesor))
            {
                $return=true;
            }
        }
        return $return;
     }
     public static function MostrarProfesores()
     {
         $return = false;
         $lista = Datos::getJson(self::ARCHIVO);
         foreach ($lista as $profesor)
        {
            echo "Legajo: {$profesor->legajo}, Nombre: {$profesor->nombre}" . PHP_EOL;
            $return = true;
        }
        return $return;
     }

     public static function ProfesorAlreadyExists($profesor)
     {
        $return = false;
        $lista = Datos::getJson(self::ARCHIVO);
        if ($lista==true)
        {
            foreach ($lista as $item)
            {
                if ($item->legajo == $profesor->legajo)
                {
                    $return = true;
                break;
                }
            }
        }
        return $return;

     }
     public static function ProfesorAlreadyExistsByLegajo($legajo)
     {
        $return = false;
        $lista = Datos::getJson(self::ARCHIVO);
        if ($lista==true)
        {
            foreach ($lista as $item)
            {
                if ($item->legajo == $legajo)
                {
                    $return = true;
                break;
                }
            }
        }
        return $return;

     }
}