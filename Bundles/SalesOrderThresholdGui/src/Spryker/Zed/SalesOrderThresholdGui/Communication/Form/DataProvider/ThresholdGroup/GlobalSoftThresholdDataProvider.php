<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderThresholdGui\Communication\Form\DataProvider\ThresholdGroup;

use Generated\Shared\Transfer\SalesOrderThresholdTransfer;
use Spryker\Zed\SalesOrderThresholdGui\Communication\Form\GlobalThresholdType;
use Spryker\Zed\SalesOrderThresholdGui\Communication\Form\Type\ThresholdGroup\GlobalSoftThresholdType;

class GlobalSoftThresholdDataProvider extends AbstractGlobalThresholdDataProvider implements ThresholdStrategyDataProviderInterface
{
    /**
     * @param array $data
     * @param \Generated\Shared\Transfer\SalesOrderThresholdTransfer $salesOrderThresholdTransfer
     *
     * @return array
     */
    public function getData(array $data, SalesOrderThresholdTransfer $salesOrderThresholdTransfer): array
    {
        $thresholdData = $data[GlobalThresholdType::FIELD_SOFT] ?? [];
        $thresholdData[GlobalSoftThresholdType::FIELD_ID_THRESHOLD] = $salesOrderThresholdTransfer->getIdSalesOrderThreshold();
        $thresholdData[GlobalSoftThresholdType::FIELD_THRESHOLD] = $salesOrderThresholdTransfer->getSalesOrderThresholdValue()->getThreshold();

        $thresholdData = $this->getExpandersData($thresholdData, $salesOrderThresholdTransfer);
        $thresholdData = $this->getLocalizedMessages($thresholdData, $salesOrderThresholdTransfer);

        $data[GlobalThresholdType::FIELD_SOFT] = $thresholdData;

        return $data;
    }
}
