<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ProductStorage\Storage;

interface ProductConcreteStorageReaderInterface
{
    /**
     * @deprecated Use findProductConcreteStorageData($idProductConcrete, $localeName): ?array
     *
     * @param int $idProductConcrete
     * @param string $localeName
     *
     * @return array
     */
    public function getProductConcreteStorageData($idProductConcrete, $localeName);

    /**
     * @param int $idProductConcrete
     * @param string $localeName
     *
     * @return array|null
     */
    public function findProductConcreteStorageData($idProductConcrete, $localeName): ?array;

    /**
     * @param int[] $productIds
     *
     * @return \Generated\Shared\Transfer\ProductConcreteStorageTransfer[]
     */
    public function getProductConcreteStorageTransfersForCurrentLocale(array $productIds): array;
    /**
     * @param int $idProductConcrete
     *
     * @return bool
     */
    public function isProductConcreteRestricted(int $idProductConcrete): bool;

    /**
     * @param string $mappingType
     * @param string $identifier
     * @param string $localeName
     *
     * @return array|null
     */
    public function findProductConcreteStorageDataByMapping(string $mappingType, string $identifier, string $localeName): ?array;

    /**
     * @param string $mappingType
     * @param string $identifier
     *
     * @return array|null
     */
    public function findProductConcreteStorageDataByMappingForCurrentLocale(string $mappingType, string $identifier): ?array;
}
