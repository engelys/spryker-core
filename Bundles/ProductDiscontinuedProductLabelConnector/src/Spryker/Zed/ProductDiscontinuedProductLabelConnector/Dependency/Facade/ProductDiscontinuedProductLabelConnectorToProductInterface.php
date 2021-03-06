<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductDiscontinuedProductLabelConnector\Dependency\Facade;

interface ProductDiscontinuedProductLabelConnectorToProductInterface
{
    /**
     * @param int $idProduct
     *
     * @return int|null
     */
    public function findProductAbstractIdByConcreteId(int $idProduct): ?int;

    /**
     * @param int $idProductAbstract
     *
     * @return int[]
     */
    public function findProductConcreteIdsByAbstractProductId(int $idProductAbstract): array;
}
