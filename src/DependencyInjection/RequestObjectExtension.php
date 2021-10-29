<?php

declare(strict_types=1);

namespace Orlan\RequestObject\DependencyInjection;

use Orlan\RequestObject\RequestObjectResolver;
use Orlan\RequestObject\RequestObjectSubscriber;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class RequestObjectExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $definition = new Definition(RequestObjectResolver::class);
        $definition->setAutowired(true);
        $definition->addTag('controller.argument_value_resolver');

        $container->setDefinition('request_object.event_subscriber', $definition);

        $definition = new Definition(RequestObjectSubscriber::class);
        $definition->setAutowired(true);
        $definition->addTag('kernel.event_subscriber', [
            'event' => 'kernel.controller_arguments',
            'method' => 'validate',
        ]);

        $container->setDefinition('request_object.subscriber', $definition);
    }
}
