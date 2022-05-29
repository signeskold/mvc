<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita75057940062049876a3a770a8e886d5
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'SebastianBergmann\\CliParser\\AmbiguousOptionException' => __DIR__ . '/..' . '/sebastian/cli-parser/src/exceptions/AmbiguousOptionException.php',
        'SebastianBergmann\\CliParser\\Exception' => __DIR__ . '/..' . '/sebastian/cli-parser/src/exceptions/Exception.php',
        'SebastianBergmann\\CliParser\\OptionDoesNotAllowArgumentException' => __DIR__ . '/..' . '/sebastian/cli-parser/src/exceptions/OptionDoesNotAllowArgumentException.php',
        'SebastianBergmann\\CliParser\\Parser' => __DIR__ . '/..' . '/sebastian/cli-parser/src/Parser.php',
        'SebastianBergmann\\CliParser\\RequiredOptionArgumentMissingException' => __DIR__ . '/..' . '/sebastian/cli-parser/src/exceptions/RequiredOptionArgumentMissingException.php',
        'SebastianBergmann\\CliParser\\UnknownOptionException' => __DIR__ . '/..' . '/sebastian/cli-parser/src/exceptions/UnknownOptionException.php',
        'SebastianBergmann\\FileIterator\\Facade' => __DIR__ . '/..' . '/phpunit/php-file-iterator/src/Facade.php',
        'SebastianBergmann\\FileIterator\\Factory' => __DIR__ . '/..' . '/phpunit/php-file-iterator/src/Factory.php',
        'SebastianBergmann\\FileIterator\\Iterator' => __DIR__ . '/..' . '/phpunit/php-file-iterator/src/Iterator.php',
        'SebastianBergmann\\PHPCPD\\Application' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CLI/Application.php',
        'SebastianBergmann\\PHPCPD\\Arguments' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CLI/Arguments.php',
        'SebastianBergmann\\PHPCPD\\ArgumentsBuilder' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CLI/ArgumentsBuilder.php',
        'SebastianBergmann\\PHPCPD\\ArgumentsBuilderException' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Exceptions/ArgumentsBuilderException.php',
        'SebastianBergmann\\PHPCPD\\CodeClone' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CodeClone.php',
        'SebastianBergmann\\PHPCPD\\CodeCloneFile' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CodeCloneFile.php',
        'SebastianBergmann\\PHPCPD\\CodeCloneMap' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CodeCloneMap.php',
        'SebastianBergmann\\PHPCPD\\CodeCloneMapIterator' => __DIR__ . '/..' . '/sebastian/phpcpd/src/CodeCloneMapIterator.php',
        'SebastianBergmann\\PHPCPD\\Detector\\Detector' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Detector/Detector.php',
        'SebastianBergmann\\PHPCPD\\Detector\\Strategy\\AbstractStrategy' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Detector/Strategy/AbstractStrategy.php',
        'SebastianBergmann\\PHPCPD\\Detector\\Strategy\\DefaultStrategy' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Detector/Strategy/DefaultStrategy.php',
        'SebastianBergmann\\PHPCPD\\Exception' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Exceptions/Exception.php',
        'SebastianBergmann\\PHPCPD\\Log\\AbstractXmlLogger' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Log/AbstractXmlLogger.php',
        'SebastianBergmann\\PHPCPD\\Log\\PMD' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Log/PMD.php',
        'SebastianBergmann\\PHPCPD\\Log\\Text' => __DIR__ . '/..' . '/sebastian/phpcpd/src/Log/Text.php',
        'SebastianBergmann\\Timer\\Duration' => __DIR__ . '/..' . '/phpunit/php-timer/src/Duration.php',
        'SebastianBergmann\\Timer\\Exception' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/Exception.php',
        'SebastianBergmann\\Timer\\NoActiveTimerException' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/NoActiveTimerException.php',
        'SebastianBergmann\\Timer\\ResourceUsageFormatter' => __DIR__ . '/..' . '/phpunit/php-timer/src/ResourceUsageFormatter.php',
        'SebastianBergmann\\Timer\\TimeSinceStartOfRequestNotAvailableException' => __DIR__ . '/..' . '/phpunit/php-timer/src/exceptions/TimeSinceStartOfRequestNotAvailableException.php',
        'SebastianBergmann\\Timer\\Timer' => __DIR__ . '/..' . '/phpunit/php-timer/src/Timer.php',
        'SebastianBergmann\\Version' => __DIR__ . '/..' . '/sebastian/version/src/Version.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita75057940062049876a3a770a8e886d5::$classMap;

        }, null, ClassLoader::class);
    }
}
