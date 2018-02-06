<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2f3d281fe6dadedd5f3af9d6b8e868be
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SpotifyWebAPI\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SpotifyWebAPI\\' => 
        array (
            0 => __DIR__ . '/..' . '/jwilsson/spotify-web-api-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2f3d281fe6dadedd5f3af9d6b8e868be::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2f3d281fe6dadedd5f3af9d6b8e868be::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
