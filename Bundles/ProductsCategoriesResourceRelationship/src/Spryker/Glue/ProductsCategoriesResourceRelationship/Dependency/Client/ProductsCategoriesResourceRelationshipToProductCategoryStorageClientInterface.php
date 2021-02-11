<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductsCategoriesResourceRelationship\Dependency\Client;

interface ProductsCategoriesResourceRelationshipToProductCategoryStorageClientInterface
{
    /**
     * @param int $idProductAbstract
     * @param string $locale
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer|null
     */
    public function findProductAbstractCategory($idProductAbstract, $locale, ?string $storeName = null);

    /**
     * @param int[] $productAbstractIds
     * @param string $localeName
     * @param string|null $storeName
     *
     * @return \Generated\Shared\Transfer\ProductAbstractCategoryStorageTransfer[]
     */
    public function findBulkProductAbstractCategory(array $productAbstractIds, string $localeName, ?string $storeName = null): array;
}
