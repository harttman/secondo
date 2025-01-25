<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9cea6618ec7f99538e2df08e9667c1aa
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Secondo\\' => 8,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Secondo\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9cea6618ec7f99538e2df08e9667c1aa::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9cea6618ec7f99538e2df08e9667c1aa::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9cea6618ec7f99538e2df08e9667c1aa::$classMap;

        }, null, ClassLoader::class);
    }
}
