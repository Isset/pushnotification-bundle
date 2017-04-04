<?php

declare(strict_types=1);

namespace IssetBV\PushNotificationBundle\DependencyInjection;

use IssetBV\PushNotification\Type\Android\AndroidConnection;
use IssetBV\PushNotification\Type\Android\AndroidNotifier;
use IssetBV\PushNotification\Type\Apple\AppleConnection;
use IssetBV\PushNotification\Type\Apple\AppleNotifier;
use IssetBV\PushNotification\Type\Windows\WindowsConnection;
use IssetBV\PushNotification\Type\Windows\WindowsNotifier;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class IssetBVPushNotificationExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        if (array_key_exists('apple', $config)) {
            $this->buildApple($loader, $container, $config['apple'], $config['connection_handler']);
        }

        if (array_key_exists('android', $config)) {
            $this->buildAndroid($loader, $container, $config['android'], $config['connection_handler']);
        }

        if (array_key_exists('windows', $config)) {
            $this->buildWindows($loader, $container, $config['windows'], $config['connection_handler']);
        }
    }

    /**
     * @param YamlFileLoader $loader
     * @param ContainerBuilder $container
     * @param array $data
     * @param string $defaultConnectionHandler
     *
     * @throws \Exception
     */
    private function buildApple(YamlFileLoader $loader, ContainerBuilder $container, array $data, string $defaultConnectionHandler = null)
    {
        if ($data['connection_handler'] !== null) {
            $connectionHandler = $data['connection_handler'];
        } elseif ($defaultConnectionHandler !== null) {
            $connectionHandler = $defaultConnectionHandler;
        } else {
            $connectionHandler = 'isset_bv_push_notification.apple.connection.handler';
            $loader->load('apple.yml');
        }

        $definition = $container->register('isset_bv_push_notification.apple.notifier', AppleNotifier::class);
        $definition->addArgument(new Reference($connectionHandler));
        $definition->addTag('isset_bv_push_notification.notifier');
        foreach ($data['connections'] as $type => $connection) {
            $definition = $container->register('isset_bv_push_notification.apple.connection.' . $type, AppleConnection::class);
            $definition->addArgument($type);
            $definition->addArgument($connection['url']);
            $definition->addArgument($connection['key_location']);
            $definition->addArgument($connection['key_password_phrase'] ?? null);
            $definition->addArgument($connection['default']);
            $definition->addTag('isset_bv_push_notification.apple.connection');
        }
    }

    /**
     * @param YamlFileLoader $loader
     * @param ContainerBuilder $container
     * @param array $data
     * @param string $defaultConnectionHandler
     *
     * @throws \Exception
     */
    private function buildAndroid(YamlFileLoader $loader, ContainerBuilder $container, array $data, string $defaultConnectionHandler = null)
    {
        if ($data['connection_handler'] !== null) {
            $connectionHandler = $data['connection_handler'];
        } elseif ($defaultConnectionHandler !== null) {
            $connectionHandler = $defaultConnectionHandler;
        } else {
            $connectionHandler = 'isset_bv_push_notification.android.connection.handler';
            $loader->load('android.yml');
        }

        $definition = $container->register('isset_bv_push_notification.android.notifier', AndroidNotifier::class);
        $definition->addArgument(new Reference($connectionHandler));
        $definition->addTag('isset_bv_push_notification.notifier');

        foreach ($data['connections'] as $type => $connection) {
            $definition = $container->register('isset_bv_push_notification.android.connection.' . $type, AndroidConnection::class);
            $definition->addArgument($type);
            $definition->addArgument($connection['url']);
            $definition->addArgument($connection['api_key']);
            $definition->addArgument($connection['timeout']);
            $definition->addArgument($connection['dry_run']);
            $definition->addArgument($connection['default']);
            $definition->addTag('isset_bv_push_notification.android.connection');
        }
    }

    /**
     * @param YamlFileLoader $loader
     * @param ContainerBuilder $container
     * @param array $data
     * @param string $defaultConnectionHandler
     *
     * @throws \Exception
     */
    private function buildWindows(YamlFileLoader $loader, ContainerBuilder $container, array $data, string $defaultConnectionHandler = null)
    {
        if ($data['connection_handler'] !== null) {
            $connectionHandler = $data['connection_handler'];
        } elseif ($defaultConnectionHandler !== null) {
            $connectionHandler = $defaultConnectionHandler;
        } else {
            $connectionHandler = 'isset_bv_push_notification.windows.connection.handler';
            $loader->load('windows.yml');
        }

        $definition = $container->register('isset_bv_push_notification.windows.notifier', WindowsNotifier::class);
        $definition->addArgument(new Reference($connectionHandler));
        $definition->addTag('isset_bv_push_notification.notifier');

        foreach ($data['connections'] as $type => $connection) {
            $definition = $container->register('isset_bv_push_notification.windows.connection.' . $type, WindowsConnection::class);
            $definition->addArgument($type);
            $definition->addArgument($connection['default']);
            $definition->addTag('isset_bv_push_notification.windows.connection');
        }
    }
}
