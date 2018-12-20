<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ShoppingListsRestApi\Controller;

use Generated\Shared\Transfer\RestShoppingListAttributesTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \Spryker\Glue\ShoppingListsRestApi\ShoppingListsRestApiFactory getFactory()
 */
class ShoppingListsResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "getResourceById": {
     *          "summary": [
     *              "Retrieves a shopping list by id."
     *          ],
     *          "parameters": [
     *              {
     *                  "name": "Accept-Language",
     *                  "in": "header"
     *              },
     *              {
     *                  "name": "X-Company-User-Id",
     *                  "in": "header",
     *                  "required": true,
     *                  "description": "Company user uuid"
     *              }
     *          ],
     *          "responses": {
     *              "403": "Unauthorized request.",
     *              "404": "Shopping list is not found."
     *          }
     *     },
     *     "getCollection": {
     *          "summary": [
     *              "Retrieves list of all customer's shopping lists."
     *          ],
     *          "parameters": [
     *              {
     *                  "name": "Accept-Language",
     *                  "in": "header"
     *              },
     *              {
     *                  "name": "X-Company-User-Id",
     *                  "in": "header",
     *                  "required": true,
     *                  "description": "Company user uuid"
     *              }
     *          ],
     *          "responses": {
     *              "403": "Unauthorized request."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        $idShoppingList = $restRequest->getResource()->getId();

        if ($idShoppingList !== null) {
            return $this->getFactory()->createShoppingListsReader()->getCustomerShoppingList(
                $idShoppingList,
                $restRequest
            );
        }

        return $this->getFactory()
            ->createShoppingListsReader()
            ->getCustomerShoppingListCollection($restRequest);
    }

    /**
     * @Glue({
     *     "post": {
     *          "summary": [
     *              "Creates a shopping list."
     *          ],
     *          "parameters": [
     *              {
     *                  "name": "Accept-Language",
     *                  "in": "header"
     *              },
     *              {
     *                  "name": "X-Company-User-Id",
     *                  "in": "header",
     *                  "required": true,
     *                  "description": "Company user uuid"
     *              }
     *          ],
     *          "responses": {
     *              "401": "Write access is required.",
     *              "403": "Unauthorized request.",
     *              "422": "Cannot create a shopping list."
     *          },
     *          "responseAttributesClassName": "\\Generated\\Shared\\Transfer\\RestShoppingListAttributesTransfer"
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestShoppingListAttributesTransfer $restShoppingListAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function postAction(
        RestRequestInterface $restRequest,
        RestShoppingListAttributesTransfer $restShoppingListAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createShoppingListsCreator()
            ->createShoppingList($restRequest, $restShoppingListAttributesTransfer);
    }

    /**
     * @Glue({
     *     "patch": {
     *          "summary": [
     *              "Updates a shopping list by id."
     *          ],
     *          "parameters": [
     *              {
     *                  "name": "Accept-Language",
     *                  "in": "header"
     *              },
     *              {
     *                  "name": "X-Company-User-Id",
     *                  "in": "header",
     *                  "required": true,
     *                  "description": "Company user uuid"
     *              }
     *          ],
     *          "responses": {
     *              "400": "Shopping list id not specified.",
     *              "401": "Write access is required.",
     *              "403": "Unauthorized request.",
     *              "404": "Shopping list not found.",
     *              "422": "Cannot patch a shopping list."
     *          },
     *          "responseAttributesClassName": "\\Generated\\Shared\\Transfer\\RestShoppingListAttributesTransfer"
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     * @param \Generated\Shared\Transfer\RestShoppingListAttributesTransfer $restShoppingListAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function patchAction(
        RestRequestInterface $restRequest,
        RestShoppingListAttributesTransfer $restShoppingListAttributesTransfer
    ): RestResponseInterface {
        return $this->getFactory()
            ->createShoppingListsUpdater()
            ->updateShoppingList($restRequest, $restShoppingListAttributesTransfer);
    }

    /**
     * @Glue({
     *     "delete": {
     *          "summary": [
     *              "Deletes a shopping list by id."
     *          ],
     *          "parameters": [
     *              {
     *                  "name": "Accept-Language",
     *                  "in": "header"
     *              },
     *              {
     *                  "name": "X-Company-User-Id",
     *                  "in": "header",
     *                  "required": true,
     *                  "description": "Company user uuid"
     *              }
     *          ],
     *          "responses": {
     *              "400": "Shopping list id not specified.",
     *              "401": "Write access is required.",
     *              "403": "Unauthorized request.",
     *              "404": "Shopping list not found."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function deleteAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()
            ->createShoppingListsDeleter()
            ->deleteShoppingList($restRequest);
    }
}
