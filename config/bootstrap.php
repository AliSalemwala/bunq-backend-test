<?php

use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

// ContainerBuilder builds a container, which is used to get the app
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);

(require __DIR__ . '/routes.php')($app);

(require __DIR__ . '/middleware.php')($app);

return $app;