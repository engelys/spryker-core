<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\QuickOrder;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\QuickOrder\Dependency\Client\QuickOrderToProductStorageClientBridge;

class QuickOrderDependencyProvider extends AbstractDependencyProvider
{
    public const CLIENT_PRODUCT_STORAGE = 'CLIENT_PRODUCT_STORAGE';
    public const PLUGINS_PRODUCT_CONCRETE_EXPANDER = 'PLUGINS_PRODUCT_CONCRETE_EXPANDER';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container): Container
    {
        $container = $this->addProductStorageClient($container);
        $container = $this->addProductConcreteExpanderPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductConcreteExpanderPlugins(Container $container): Container
    {
        $container[static::PLUGINS_PRODUCT_CONCRETE_EXPANDER] = function () {
            return $this->getProductConcreteExpanderPlugins();
        };

        return $container;
    }

    /**
     * @return \Spryker\Client\QuickOrderExtension\Dependency\Plugin\ProductConcreteExpanderPluginInterface[]
     */
    protected function getProductConcreteExpanderPlugins(): array
    {
        return [];
    }

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    protected function addProductStorageClient(Container $container): Container
    {
        $container[static::CLIENT_PRODUCT_STORAGE] = function (Container $container) {
            return new QuickOrderToProductStorageClientBridge($container->getLocator()->productStorage()->client());
        };

        return $container;
    }
}
