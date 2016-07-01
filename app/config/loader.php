<?php



$loader = new \Phalcon\Loader();

$loader->registerNamespaces([
    'Phalcon' => 'C:/OpenServer/domains/phalcon-devtools/vendor/phalcon/incubator/Library/Phalcon/'
]);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->modelsDir
    )
)->register();


// $loader->register();