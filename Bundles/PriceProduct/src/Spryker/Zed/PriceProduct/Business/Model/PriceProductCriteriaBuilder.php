<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\PriceProduct\Business\Model;

use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductDimensionTransfer;
use Generated\Shared\Transfer\PriceProductFilterTransfer;
use Spryker\Zed\PriceProduct\Business\Model\PriceType\PriceProductTypeReaderInterface;
use Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToCurrencyFacadeInterface;
use Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToPriceFacadeInterface;
use Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeInterface;
use Spryker\Zed\PriceProduct\PriceProductConfig;

class PriceProductCriteriaBuilder implements PriceProductCriteriaBuilderInterface
{
    /**
     * @var \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToCurrencyFacadeInterface
     */
    protected $currencyFacade;

    /**
     * @var \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToPriceFacadeInterface
     */
    protected $priceFacade;

    /**
     * @var \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \Spryker\Zed\PriceProduct\Business\Model\PriceType\PriceProductTypeReaderInterface
     */
    protected $priceProductTypeReader;

    /**
     * @var \Spryker\Zed\PriceProduct\PriceProductConfig
     */
    protected $config;

    /**
     * @param \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToCurrencyFacadeInterface $currencyFacade
     * @param \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToPriceFacadeInterface $priceFacade
     * @param \Spryker\Zed\PriceProduct\Dependency\Facade\PriceProductToStoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\PriceProduct\Business\Model\PriceType\PriceProductTypeReaderInterface $priceProductTypeReader
     * @param \Spryker\Zed\PriceProduct\PriceProductConfig $config
     */
    public function __construct(
        PriceProductToCurrencyFacadeInterface $currencyFacade,
        PriceProductToPriceFacadeInterface $priceFacade,
        PriceProductToStoreFacadeInterface $storeFacade,
        PriceProductTypeReaderInterface $priceProductTypeReader,
        PriceProductConfig $config
    ) {
        $this->currencyFacade = $currencyFacade;
        $this->priceFacade = $priceFacade;
        $this->storeFacade = $storeFacade;
        $this->priceProductTypeReader = $priceProductTypeReader;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceProductFilterTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductCriteriaTransfer
     */
    public function buildCriteriaFromFilter(PriceProductFilterTransfer $priceProductFilterTransfer): PriceProductCriteriaTransfer
    {
        $priceProductCriteriaTransfer = (new PriceProductCriteriaTransfer())
            ->fromArray($priceProductFilterTransfer->toArray(), true);

        return $priceProductCriteriaTransfer
            ->setPriceDimension(
                $priceProductFilterTransfer->getPriceDimension()
            )
            ->setQuote(
                $priceProductFilterTransfer->getQuote()
            )
            ->setIdCurrency(
                $this->getCurrencyFromFilter($priceProductFilterTransfer)->getIdCurrency()
            )->setIdStore(
                $this->getStoreFromFilter($priceProductFilterTransfer)->getIdStore()
            )->setPriceMode(
                $this->getPriceModeFromFilter($priceProductFilterTransfer)
            )->setPriceType(
                $this->priceProductTypeReader->handleDefaultPriceType($priceProductFilterTransfer->getPriceTypeName())
            );
    }

    /**
     * @param string|null $priceTypeName
     *
     * @return \Generated\Shared\Transfer\PriceProductCriteriaTransfer
     */
    public function buildCriteriaWithDefaultValues($priceTypeName = null): PriceProductCriteriaTransfer
    {
        return (new PriceProductCriteriaTransfer())
        ->setPriceMode(
            $this->priceFacade->getDefaultPriceMode()
        )
        ->setIdCurrency(
            $this->currencyFacade->getDefaultCurrencyForCurrentStore()->getIdCurrency()
        )
        ->setIdStore(
            $this->storeFacade->getCurrentStore()->getIdStore()
        )
        ->setPriceType(
            $this->priceProductTypeReader->handleDefaultPriceType($priceTypeName)
        )
        ->setPriceDimension(
            (new PriceProductDimensionTransfer())->setType($this->config->getPriceDimensionDefault())
        );
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceFilterTransfer
     *
     * @return string
     */
    protected function getPriceModeFromFilter(PriceProductFilterTransfer $priceFilterTransfer): string
    {
        $priceMode = $priceFilterTransfer->getPriceMode();
        if (!$priceMode) {
            return $this->priceFacade->getDefaultPriceMode();
        }

        return $priceMode;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceFilterTransfer
     *
     * @return \Generated\Shared\Transfer\CurrencyTransfer
     */
    protected function getCurrencyFromFilter(PriceProductFilterTransfer $priceFilterTransfer)
    {
        if ($priceFilterTransfer->getCurrencyIsoCode()) {
            return $this->currencyFacade->fromIsoCode($priceFilterTransfer->getCurrencyIsoCode());
        }

        return $this->currencyFacade->getDefaultCurrencyForCurrentStore();
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductFilterTransfer $priceFilterTransfer
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    protected function getStoreFromFilter(PriceProductFilterTransfer $priceFilterTransfer)
    {
        if ($priceFilterTransfer->getStoreName()) {
            return $this->storeFacade->getStoreByName($priceFilterTransfer->getStoreName());
        }

        return $this->storeFacade->getCurrentStore();
    }
}
