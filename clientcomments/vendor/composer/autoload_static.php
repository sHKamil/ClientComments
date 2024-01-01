<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteb4672d353195a6d3f31d237d2016569
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PrestaShop\\Module\\ClientComments\\Classes\\' => 41,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PrestaShop\\Module\\ClientComments\\Classes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Prestashop\\Module\\Clientcomments\\Classes\\ClientcommentsModel' => __DIR__ . '/../..' . '/classes/ClientcommentsModel.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteb4672d353195a6d3f31d237d2016569::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteb4672d353195a6d3f31d237d2016569::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteb4672d353195a6d3f31d237d2016569::$classMap;

        }, null, ClassLoader::class);
    }
}