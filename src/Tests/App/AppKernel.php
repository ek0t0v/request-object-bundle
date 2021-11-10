<?php

declare(strict_types=1);

namespace Ek0t0v\RequestObjectBundle\Tests\App;

use Ek0t0v\RequestObjectBundle\RequestObjectBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class AppKernel extends Kernel
{
    use MicroKernelTrait;

    ///**
    // * @throws \Throwable
    // */
    //public function registerContainerConfiguration(LoaderInterface $loader): void
    //{
    //    $loader->load($this->getProjectDir().'/src/Tests/App/config.yaml');
    //}

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('config.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('routing.yaml');
    }

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new RequestObjectBundle(),
        ];
    }
}
