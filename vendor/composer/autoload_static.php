<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite5ec0eb8e8dfe7dd1be8b423f60e0ce3
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite5ec0eb8e8dfe7dd1be8b423f60e0ce3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite5ec0eb8e8dfe7dd1be8b423f60e0ce3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInite5ec0eb8e8dfe7dd1be8b423f60e0ce3::$classMap;

        }, null, ClassLoader::class);
    }
}
