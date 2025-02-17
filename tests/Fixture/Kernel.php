<?php

/*
 * This file is part of the zenstruck/console-test package.
 *
 * (c) Kevin Bond <kevinbond@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zenstruck\Console\Test\Tests\Fixture;

use Psr\Log\NullLogger;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        yield new FrameworkBundle();
    }

    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader): void
    {
        $c->register(FixtureCommand::class)
            ->setAutoconfigured(true)
            ->setAutowired(true)
        ;
        $c->register(FixtureAttributeCommand::class)
            ->setAutoconfigured(true)
            ->setAutowired(true)
        ;
        $c->register('logger', NullLogger::class);
        $c->loadFromExtension('framework', [
            'secret' => 'S3CRET',
            'test' => true,
            'router' => ['utf8' => true],
            'secrets' => false,
        ]);
    }

    /**
     * BC Layer.
     *
     * @param mixed $routes
     */
    protected function configureRoutes($routes): void
    {
        // noop
    }
}
