<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MinimumOrderValue\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface MinimumOrderValueToStoreFacadeInterface
{
    /**
     * @param string $storeByName
     *
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getStoreByName(string $storeByName): StoreTransfer;
}
