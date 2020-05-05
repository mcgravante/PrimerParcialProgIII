<?php
class Materia
{
    const ARCHIVO = "materias.json";
    public $id;
    public $nombre;
    public $cuatrimestre;

    public function __construct($nombre, $cuatrimestre)
    {
        $this->id = uniqid();
        $this->nombre = $nombre;
        $this->cuatrimestre = $cuatrimestre;
    }

    public static function Save($nombre, $cuatrimestre)
     {
        $return=false;
        $materia = new Materia($nombre, $cuatrimestre);
        $lista = Datos::getJson(self::ARCHIVO);
        if (Materia::MateriaAlreadyExists($materia))
        {
            $return = "La materia ya existe";
        }else
        {
            if (Datos::GuardarJSON(self::ARCHIVO,$materia))
            {
                $return=true;
            }
        }
        return $return;
     }

    public static function MostrarMaterias()
    {
         $return = false;
         $lista = Datos::getJson(self::ARCHIVO);
         foreach ($lista as $materia)
        {
             echo "Id: {$materia->id}, Nombre: {$materia->nombre}, Cuatrimestre: {$materia->cuatrimestre}" . PHP_EOL;
             $return = true;
        }
         return $return;
    }

     public static function MateriaAlreadyExists($materia)
     {
        $return = false;
        $lista = Datos::getJson(self::ARCHIVO);
        if ($lista==true)
        {
            foreach ($lista as $item)
            {
                if ($item->nombre == $materia->nombre && $item->cuatrimestre == $materia->cuatrimestre)
                {
                    $return = true;
                break;
                }
            }
        }
        return $return;
    }

    public static function MateriaAlreadyExistsById($id)
    {
        $return = false;
        $lista = Datos::getJson(self::ARCHIVO);
        if ($lista==true)
        {
            foreach ($lista as $item)
            {
                if ($item->id == $id)
                {
                    $return = true;
                break;
                }
            }
        }
        return $return;
    }
}