<?php

declare(strict_types=1);

namespace IssetBV\PushNotificationBundle;

use IssetBV\PushNotificationBundle\DependencyInjection\Compiler\ConnectionCompiler;
use IssetBV\PushNotificationBundle\DependencyInjection\Compiler\NotifierCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class IssetBVPushNotificationBundle.
 */
class IssetBVPushNotificationBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new ConnectionCompiler());
        $container->addCompilerPass(new NotifierCompiler());
    }
}
