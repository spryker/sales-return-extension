<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Category\Communication\Controller;

use Spryker\Shared\Category\CategoryConstants;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;

/**
 * @method \Spryker\Zed\Category\Business\CategoryFacadeInterface getFacade()
 * @method \Spryker\Zed\Category\Communication\CategoryCommunicationFactory getFactory()
 * @method \Spryker\Zed\Category\Persistence\CategoryQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Category\Persistence\CategoryRepositoryInterface getRepository()
 */
class ReSortController extends AbstractController
{
    protected const PARAM_RE_SORT_FORM_TOKEN_ID = 'category_nodes_re_sort_token';
    protected const PARAM_REQUEST_RE_SORT_FORM_TOKEN = 'token';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $idCategoryNode = $request->get(CategoryConstants::PARAM_ID_NODE);
        $localeTransfer = $this->getFactory()->getCurrentLocale();

        $categoryNodeCollection = $this
            ->getQueryContainer()
            ->getCategoryNodesWithOrder($idCategoryNode, $localeTransfer->getIdLocale())
            ->find();

        $items = [];
        foreach ($categoryNodeCollection as $categoryNodeEntity) {
            $items[] = [
                'id' => $categoryNodeEntity->getIdCategoryNode(),
                'text' => $categoryNodeEntity
                    ->getCategory()
                    ->getLocalisedAttributes($localeTransfer->getIdLocale())
                    ->getFirst()
                    ->getName(),
            ];
        }

        return [
            'items' => $items,
        ];
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function saveAction(Request $request)
    {
        if (!$this->isCsrfTokenValid($request->get(static::PARAM_REQUEST_RE_SORT_FORM_TOKEN))) {
            return $this->jsonResponse([
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => 'CSRF token is not valid.',
            ]);
        }

        $categoryNodesToReorder = (array)json_decode($request->request->get('nodes'), true);
        $positionCursor = count($categoryNodesToReorder);

        foreach ($categoryNodesToReorder as $index => $nodeData) {
            $idCategoryNode = $this->castId($nodeData['id']);

            $this->getFacade()->updateCategoryNodeOrder($idCategoryNode, $positionCursor);

            $positionCursor--;
        }

        return $this->jsonResponse([
            'code' => Response::HTTP_OK,
            'message' => 'Category nodes successfully re-sorted.',
        ]);
    }

    /**
     * @param string|null $token
     *
     * @return bool
     */
    protected function isCsrfTokenValid(?string $token): bool
    {
        if (!$token) {
            return false;
        }

        $csrfToken = new CsrfToken(static::PARAM_RE_SORT_FORM_TOKEN_ID, $token);

        return $this->getFactory()->getCsrfTokenManager()->isTokenValid($csrfToken);
    }
}
