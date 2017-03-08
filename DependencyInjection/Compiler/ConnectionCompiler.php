<?php

declare(strict_types=1);

namespace IssetBV\PushNotificationBundle\DependencyInjection\Compiler;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ConnectionCompiler.
 */
class ConnectionCompiler implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @throws \LogicException
     */
    public function process(ContainerBuilder $container)
    {
        $this->buildApple($container);
        $this->buildAndroid($container);
        $this->buildWindows($container);
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws LogicException
     */
    private function buildAndroid(ContainerBuilder $container)
    {
        $tag = 'isset_bv_push_notification.android.connection.handler';
        if (!$container->hasDefinition($tag)) {
            return;
        }
        $definition = $container->getDefinition($tag);

        $taggedServices = $container->findTaggedServiceIds('isset_bv_push_notification.android.connection');
        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addConnection', [
                new Reference($id),
            ]);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws LogicException
     */
    private function buildApple(ContainerBuilder $container)
    {
        $tag = 'isset_bv_push_notification.apple.connection.handler';
        if (!$container->hasDefinition($tag)) {
            return;
        }
        $definition = $container->getDefinition($tag);

        $taggedServices = $container->findTaggedServiceIds('isset_bv_push_notification.apple.connection');
        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addConnection', [
                new Reference($id),
            ]);
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @throws LogicException
     */
    private function buildWindows(ContainerBuilder $container)
    {
        $tag = 'isset_bv_push_notification.windows.connection.handler';
        if (!$container->hasDefinition($tag)) {
            return;
        }
        $definition = $container->getDefinition($tag);

        $taggedServices = $container->findTaggedServiceIds('isset_bv_push_notification.windows.connection');
        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addConnection', [
                new Reference($id),
            ]);
        }
    }
}
