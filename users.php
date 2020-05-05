<?php

use \Firebase\JWT\JWT;
require_once __DIR__ .'/vendor/autoload.php';
include_once './datos.php';
 class User
 {
     const ARCHIVO = "users.json";
     const KEY = "pro3-parcial";
     public $email;
     public $clave;

     public function __construct($email,$clave)
     {
        $this->email=$email;
        $this->clave=$clave;
     }

     public static function Singin($email,$clave)
     {
        $return=false;
        $newUser = new User($email,$clave);
        $alreadySignedIn = false;
        $arrayJson= Datos::getJson(self::ARCHIVO);
        if (!is_null($arrayJson))
        {
            foreach ($arrayJson as $item) 
            {
                if ($item->email == $email) 
                {
                    $alreadySignedIn=TRUE;
                }
            }        
        }
        if(!$alreadySignedIn)
        {
            if (Datos::GuardarJSON(self::ARCHIVO,$newUser))
            {
                $return=true;
            }
        }else{
            echo "Usuario ya registrado con ese mail";
        }
        return $return;
     }

     public static function Login($email,$clave)
     {
        $return=false;
        $response = Datos::getJson("users.json");

        if ($response!=false)
        {
            foreach ($response as $user)
            {
            if (User::validar($email, $clave, $user->email, $user->clave))
                {
                    $payload = array(
                        "email" => $email,
                        "clave" => $clave,
                    );
                    $return=true;
                break;
                }
            }
        }
        if ($return)
        {
            $return = JWT::encode($payload, self::KEY);
        }else{
            echo "Usuario o contraseña invalidos.";
        }
        return $return;
     }

    public static function validar($email,$clave, $emailNew, $passNew)
    {
        $return = false;
         if ($passNew == $clave && $email==$emailNew)
         {
             
            $return = true;
         }
        return $return;
    }

    public static function IsUser($token)
     {
        $response=false;
        try
        {
            $users = JWT::decode($token, self::KEY, array("HS256"));
            $response=true;
        }catch(Exception $ex)
        {
            return $response;
        }
        return $response;
     }
 }