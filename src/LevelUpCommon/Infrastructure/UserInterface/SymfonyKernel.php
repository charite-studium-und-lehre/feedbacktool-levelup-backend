<?php

namespace LevelUpCommon\Infrastructure\UserInterface;

use Common\Application\CommandHandler\CommandHandler;
use Common\Application\DomainEvent\DomainEventSubscriber;
use Common\Infrastructure\Events\DomainEventCompilerPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class SymfonyKernel extends BaseKernel
{
    use MicroKernelTrait;

    const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function getCacheDir() {
        return $this->getProjectDir() . '/var/cache/' . $this->environment;
    }

    public function getLogDir() {
        return $this->getProjectDir() . '/var/log';
    }

    public function registerBundles() {
        $contents = require $this->getProjectDir() . '/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    /** @return void */
    protected function build(ContainerBuilder $container) {
        $container->registerForAutoconfiguration(DomainEventSubscriber::class)
            ->addTag('ddd.domainEventSubscriber');
        $container
            ->registerForAutoconfiguration(CommandHandler::class)
            ->addTag('ddd.domainCommandHandler');
    }

    /** @return void */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader) {
        $container->setParameter('container.autowiring.strict_mode', TRUE);
        $container->setParameter('container.dumper.inline_class_loader', TRUE);
        $confDir = $this->getProjectDir() . '/config';
        $loader->load($confDir . '/packages/*' . self::CONFIG_EXTS, 'glob');
        if (is_dir($confDir . '/packages/' . $this->environment)) {
            $loader->load($confDir . '/packages/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        }
        $loader->load($confDir . '/services' . self::CONFIG_EXTS, 'glob');
        $loader->load($confDir . '/services_' . $this->environment . self::CONFIG_EXTS, 'glob');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void {
        $confDir = $this->getProjectDir() . '/config';
        if (is_dir($confDir . '/routes/')) {
            $routes->import($confDir . '/routes/*' . self::CONFIG_EXTS, 'glob');
        }
        if (is_dir($confDir . '/routes/' . $this->environment)) {
            $routes->import($confDir . '/routes/' . $this->environment . '/**/*' . self::CONFIG_EXTS, 'glob');
        }
        $routes->import($confDir . '/routes' . self::CONFIG_EXTS, 'glob');
    }
}
