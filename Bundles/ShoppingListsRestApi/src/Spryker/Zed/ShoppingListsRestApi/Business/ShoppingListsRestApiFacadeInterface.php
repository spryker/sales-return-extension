<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListsRestApi\Business;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\RestShoppingListItemRequestTransfer;
use Generated\Shared\Transfer\RestShoppingListRequestTransfer;
use Generated\Shared\Transfer\ShoppingListCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemResponseTransfer;
use Generated\Shared\Transfer\ShoppingListResponseTransfer;

interface ShoppingListsRestApiFacadeInterface
{
    /**
     * Specification:
     *  - Gets company user id by the uuid
     *  - Gets shopping list collection by the customer reference and the company user id.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListCollectionTransfer
     */
    public function getCustomerShoppingListCollection(
        CustomerTransfer $customerTransfer
    ): ShoppingListCollectionTransfer;

    /**
     * Specification:
     *  - Gets company user id by the uuid
     *  - Finds shopping list by the uuid, the customer reference and the company user id.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestShoppingListRequestTransfer $restShoppingListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function findShoppingListByUuid(
        RestShoppingListRequestTransfer $restShoppingListRequestTransfer
    ): ShoppingListResponseTransfer;

    /**
     * Specification:
     *  - Creates new shopping list if shopping list with given name does not already exist.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestShoppingListRequestTransfer $restShoppingListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function createShoppingList(
        RestShoppingListRequestTransfer $restShoppingListRequestTransfer
    ): ShoppingListResponseTransfer;

    /**
     * Specification:
     *  - Updates the shopping list's name if shopping list with given name does not already exist.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestShoppingListRequestTransfer $restShoppingListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function updateShoppingList(
        RestShoppingListRequestTransfer $restShoppingListRequestTransfer
    ): ShoppingListResponseTransfer;

    /**
     * Specification:
     *  - Deletes the shopping list.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestShoppingListRequestTransfer $restShoppingListRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListResponseTransfer
     */
    public function deleteShoppingList(
        RestShoppingListRequestTransfer $restShoppingListRequestTransfer
    ): ShoppingListResponseTransfer;

    /**
     * Specification:
     *  - Retrieves company user by uuid.
     *  - Checks that company user belongs to current customer.
     *  - Retrieves shopping list by uuid.
     *  - Adds item to shopping list.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\RestShoppingListItemRequestTransfer $restShoppingListItemRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemResponseTransfer
     */
    public function addItem(
        RestShoppingListItemRequestTransfer $restShoppingListItemRequestTransfer
    ): ShoppingListItemResponseTransfer;
}
