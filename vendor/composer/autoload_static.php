<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit416168c4d8cc47a46c922993be7d780f
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Seld\\CliPrompt\\' => 15,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'L' => 
        array (
            'League\\CLImate\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Seld\\CliPrompt\\' => 
        array (
            0 => __DIR__ . '/..' . '/seld/cli-prompt/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'League\\CLImate\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/climate/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/src',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit416168c4d8cc47a46c922993be7d780f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit416168c4d8cc47a46c922993be7d780f::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit416168c4d8cc47a46c922993be7d780f::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInit416168c4d8cc47a46c922993be7d780f::$classMap;

        }, null, ClassLoader::class);
    }
}
