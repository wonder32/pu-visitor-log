<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit195e90eefacedd4c46fad1564b7d3ade
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pvl\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pvl\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit195e90eefacedd4c46fad1564b7d3ade::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit195e90eefacedd4c46fad1564b7d3ade::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}