<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [
        __DIR__ . '/app/',
        __DIR__ . '/bootstrap/',
        __DIR__ . '/config/',
        __DIR__ . '/database/',
        __DIR__ . '/public/',
        __DIR__ . '/routes/',
        __DIR__ . '/tests/',
    ]);
    $parameters->set(Option::SKIP, [
        'config/insights.php',
    ]);

    // Define what rule sets will be applied
    $containerConfigurator->import(SetList::PHP_80);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
