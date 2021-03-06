<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit86259b5e499dfc4e155de2899ba85280
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit86259b5e499dfc4e155de2899ba85280::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit86259b5e499dfc4e155de2899ba85280::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
