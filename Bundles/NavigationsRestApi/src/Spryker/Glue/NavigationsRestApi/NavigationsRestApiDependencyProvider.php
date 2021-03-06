<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\NavigationsRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;
use Spryker\Glue\NavigationsRestApi\Dependency\Client\NavigationsRestApiToNavigationStorageClientBridge;

/**
 * @method \Spryker\Glue\NavigationsRestApi\NavigationsRestApiConfig getConfig()
 */
class NavigationsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const CLIENT_NAVIGATION_STORAGE = 'CLIENT_NAVIGATION_STORAGE';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addNavigationStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addNavigationStorageClient(Container $container): Container
    {
        $container[static::CLIENT_NAVIGATION_STORAGE] = function (Container $container) {
            return new NavigationsRestApiToNavigationStorageClientBridge(
                $container->getLocator()->navigationStorage()->client()
            );
        };

        return $container;
    }
}
