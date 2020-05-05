<?php
class Asignacion
{
    const ARCHIVO = "materias-profesores.json";
    const TURNO = ['manana', 'noche'];
    public $legajoprofe;
    public $idmateria;
    public $turno;

    public function __construct($legajoprofe, $idmateria, $turno)
    {
        $this->legajoprofe = $legajoprofe;
        $this->idmateria = $idmateria;
        $this->turno = $turno;
    }

    public static function Save($legajoprofe, $idmateria, $turno)
     {
        $return=false;
        $asignacion = new Asignacion($legajoprofe, $idmateria, $turno);
        $lista = Datos::getJson(self::ARCHIVO);
        if (!in_array($turno, self::TURNO))
        {
            $return = "No existe el turno. Usar manana o noche";
        }
        else
        {
            if (Asignacion::AsignacionAlreadyExists($asignacion))
            {
                $return = "Ya tiene asignada una materia en ese turno y cuatrimestre";
            }
            elseif (!Materia::MateriaAlreadyExistsById($idmateria)) {
                $return = "No existe materia con ese id";
            }
            elseif (!Profesor::ProfesorAlreadyExistsByLegajo($legajoprofe)) {
                $return = "No existe profesor con ese legajo";
            }
           else
           {
               if (Datos::GuardarJSON(self::ARCHIVO,$asignacion))
               {
                   $return=true;
               }
           }
        }
        return $return;
     }
     public static function MostrarAsignaciones()
     {
          $return = false;
          $lista = Datos::getJson(self::ARCHIVO);
          foreach ($lista as $asignacion)
         {
              echo "Legajo Profesor: {$asignacion->legajoprofe}, Id Materia: {$asignacion->idmateria}, Turno: {$asignacion->turno}" . PHP_EOL;
              $return = true;
         }
          return $return;
     }

     public static function AsignacionAlreadyExists($asignacion)
     {
        $return = false;
        $lista = Datos::getJson(self::ARCHIVO);
        if ($lista==true)
        {
            foreach ($lista as $item)
            {
                if ($item->legajoprofe == $asignacion->legajoprofe && $item->idmateria == $asignacion->idmateria && $item->turno == $asignacion->turno)
                {
                    $return = true;
                break;
                }
            }
        }
        return $return;

     }
}