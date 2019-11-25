<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Payment\Persistence;

use Generated\Shared\Transfer\PaymentProviderCollectionTransfer;
use Generated\Shared\Transfer\SalesPaymentMethodTypeCollectionTransfer;
use Generated\Shared\Transfer\SalesPaymentMethodTypeTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\Payment\Persistence\PaymentPersistenceFactory getFactory()
 */
class PaymentRepository extends AbstractRepository implements PaymentRepositoryInterface
{
    /**
     * @return \Generated\Shared\Transfer\SalesPaymentMethodTypeCollectionTransfer
     */
    public function getSalesPaymentMethodTypesCollection(): SalesPaymentMethodTypeCollectionTransfer
    {
        $salesPaymentMethodTypeEntities = $this->getFactory()
            ->createSalesPaymentMethodTypeQuery()
            ->find();

        $salesPaymentMethodTypeCollectionTransfer = new SalesPaymentMethodTypeCollectionTransfer();

        $paymentMapper = $this->getFactory()->createPaymentMapper();
        foreach ($salesPaymentMethodTypeEntities as $salesPaymentMethodTypeEntity) {
            $salesPaymentMethodTypeTransfer = $paymentMapper->mapSalesPaymentMethodTypeTransfer(
                $salesPaymentMethodTypeEntity,
                new SalesPaymentMethodTypeTransfer()
            );
            $salesPaymentMethodTypeCollectionTransfer->addSalesPaymentMethodType($salesPaymentMethodTypeTransfer);
        }

        return $salesPaymentMethodTypeCollectionTransfer;
    }

    /**
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\PaymentProviderCollectionTransfer
     */
    public function getAvailablePaymentProvidersForStore(string $storeName): PaymentProviderCollectionTransfer
    {
        $paymentProviderCollectionTransfer = new PaymentProviderCollectionTransfer();
        $paymentProviderEntities = $this->getFactory()
            ->createPaymentProviderQuery()
            ->usePaymentMethodsQuery()
                ->filterByIsActive(true)
                ->usePaymentMethodStoreQuery()
                    ->useStoreQuery()
                        ->filterByName($storeName)
                    ->endUse()
                ->endUse()
            ->endUse()
            ->groupByIdPaymentProvider()
            ->find();

        if (!$paymentProviderEntities->getData()) {
            return $paymentProviderCollectionTransfer;
        }

        return $this->getFactory()
            ->createPaymentMapper()
            ->mapPaymentProviderEntityCollectionToPaymentProviderCollectionTransfer(
                $paymentProviderEntities,
                $paymentProviderCollectionTransfer
            );
    }
}
