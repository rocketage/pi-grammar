<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

/**
 * @author Koen Vinken <vinkenkoen@gmail.com>
 */
class MicroKernel extends Kernel
{
    public $isMamp = false;

    use MicroKernelTrait;

    /*
     * {@inheritDoc}
     */
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
        }

        return $bundles;
    }

    /*
     * {@inheritDoc}
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $routes->mount('/_wdt', $routes->import('@WebProfilerBundle/Resources/config/routing/wdt.xml'));
            $routes->mount(
                '/_profiler',
                $routes->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')
            );
        }

        $routes->mount('/', $routes->import('@AppBundle/Controller', 'annotation'));
    }

    /*
     * {@inheritDoc}
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function getCacheDir()
    {
        return $this->isMamp ? parent::getCacheDir() : '/tmp/cache';
    }

    public function getLogDir()
    {
        return $this->isMamp ? parent::getLogDir() : '/tmp/log';
    }
}
