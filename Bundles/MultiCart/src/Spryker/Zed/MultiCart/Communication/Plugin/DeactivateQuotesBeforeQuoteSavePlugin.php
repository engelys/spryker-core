<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MultiCart\Communication\Plugin;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\QuoteExtension\Dependency\Plugin\QuoteWritePluginInterface;

/**
 * @method \Spryker\Zed\MultiCart\Communication\MultiCartCommunicationFactory getFactory()
 * @method \Spryker\Zed\MultiCart\Business\MultiCartFacadeInterface getFacade()
 * @method \Spryker\Zed\MultiCart\MultiCartConfig getConfig()
 */
class DeactivateQuotesBeforeQuoteSavePlugin extends AbstractPlugin implements QuoteWritePluginInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function execute(QuoteTransfer $quoteTransfer): QuoteTransfer
    {
        $quoteTransfer->setIsDefault(true);
        $this->getFacade()->resetQuoteDefaultFlagByCustomer($quoteTransfer->getCustomer()->getCustomerReference());

        return $quoteTransfer;
    }
}
