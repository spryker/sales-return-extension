<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProductStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\MerchantProductStorage\Persistence\MerchantProductStorageEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantProductStorage\Persistence\MerchantProductStorageRepositoryInterface getRepository()
 * @method \Spryker\Zed\MerchantProductStorage\Business\MerchantProductStorageBusinessFactory getFactory()
 */
class MerchantProductStorageFacade extends AbstractFacade implements MerchantProductStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function writeMerchantProductStorageCollectionByIdProductAbstractEvents(array $eventTransfers): void
    {
        $this->getFactory()->createMerchantProductStorageWriter()->writeCollectionByIdProductAbstractEvents($eventTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     *
     * @return void
     */
    public function deleteMerchantProductStorageCollectionByIdProductAbstractEvents(array $eventTransfers): void
    {
        $this->getFactory()->createMerchantProductStorageDeleter()->deleteCollectionByIdProductAbstractEvents($eventTransfers);
    }
}
