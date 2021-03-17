<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesReturnExtension\Dependency\Plugin;

use Generated\Shared\Transfer\ReturnCreateRequestTransfer;
use Generated\Shared\Transfer\ReturnResponseTransfer;

/**
 * Allows to validate create return request.
 */
interface ReturnCreateRequestValidatorPluginInterface
{
    /**
     * Specification:
     * - Validates the request for return creation.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ReturnCreateRequestTransfer $returnCreateRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ReturnResponseTransfer
     */
    public function validate(ReturnCreateRequestTransfer $returnCreateRequestTransfer): ReturnResponseTransfer;
}
