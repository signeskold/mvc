<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitfe0a44d9ade16fff4e56abc17cb87844
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitfe0a44d9ade16fff4e56abc17cb87844', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitfe0a44d9ade16fff4e56abc17cb87844', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitfe0a44d9ade16fff4e56abc17cb87844::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
