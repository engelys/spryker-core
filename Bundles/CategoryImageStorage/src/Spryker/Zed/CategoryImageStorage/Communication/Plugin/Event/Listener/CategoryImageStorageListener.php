<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CategoryImageStorage\Communication\Plugin\Event\Listener;

use Spryker\Zed\Event\Dependency\Plugin\EventBulkHandlerInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

/**
 * @method \Spryker\Zed\CategoryImageStorage\Communication\CategoryImageStorageCommunicationFactory getFactory()
 * @method \Spryker\Zed\CategoryImageStorage\Business\CategoryImageStorageFacadeInterface getFacade()
 * @method \Spryker\Zed\CategoryImageStorage\Persistence\CategoryImageStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\CategoryImageStorage\CategoryImageStorageConfig getConfig()
 */
class CategoryImageStorageListener extends AbstractPlugin implements EventBulkHandlerInterface
{
    use DatabaseTransactionHandlerTrait;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $this->preventTransaction();

        $categoryImageIds = $this->getFactory()
            ->getEventBehaviorFacade()
            ->getEventTransferIds($eventTransfers);
        $categoryIds = $this->getRepository()
            ->getCategoryIdsByCategoryImageIds($categoryImageIds)
            ->getData();
        $this->getFacade()->publishCategoryImages($categoryIds);
    }
}
