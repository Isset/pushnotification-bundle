<?php

declare(strict_types=1);

namespace IssetBV\PushNotificationBundle\DependencyInjection\Compiler;

use LogicException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NotifierCompiler.
 */
class NotifierCompiler implements CompilerPassInterface
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
        $tag = 'isset_bv_push_notification.center';
        if (!$container->hasDefinition($tag)) {
            throw new LogicException('tag not found ' . $tag);
        }
        $definition = $container->getDefinition($tag);

        $taggedServices = $container->findTaggedServiceIds('isset_bv_push_notification.notifier');
        foreach (array_keys($taggedServices) as $id) {
            $definition->addMethodCall('addNotifier', [
                new Reference($id),
            ]);
        }
    }
}
