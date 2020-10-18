<?php

declare(strict_types=1);

namespace Track;

require_once __DIR__ . '/vendor/autoload.php';

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;
use Track\Command\DropoutsCommand;
use Track\Command\TopVsBottomCommand;

$resources = [
    'commands.yml',
    'services.yml',
    'usecases.yml',
];

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

$container = new ContainerBuilder();
$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/DependencyInjection'));

foreach ($resources as $resource) {
    try {
        $loader->load($resource);
    } catch (Exception $e) {
        die('Failed to load service configurations.');
    }
}

$container->compile(true);

try {
    $application = new Application();
    $application->addCommands(
        [
            $container->get(DropoutsCommand::class),
            $container->get(TopVsBottomCommand::class),
        ]
    );
} catch (Exception $e) {
    die('Failed to initialize the application.');
}

try {
    $application->run();
} catch (Exception $e) {
    die('Failed to execute the application.');
}
