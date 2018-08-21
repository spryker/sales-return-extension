<?php
/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductsProductImageSetsResourceRelationship\Processor\Mapper;

use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\ProductsProductImageSetsResourceRelationship\Dependency\RestResource\ProductsProductImageSetsResourceRelationshipToProductImageSetsRestApiInterface;

class ConcreteProductsProductProductImageSetsResourceRelationshipMapper implements ConcreteProductsProductImageSetsResourceRelationshipMapperInterface
{
    /**
     * @var \Spryker\Glue\ProductsProductImageSetsResourceRelationship\Dependency\RestResource\ProductsProductImageSetsResourceRelationshipToProductImageSetsRestApiInterface
     */
    protected $productImageSetsResource;

    /**
     * @param \Spryker\Glue\ProductsProductImageSetsResourceRelationship\Dependency\RestResource\ProductsProductImageSetsResourceRelationshipToProductImageSetsRestApiInterface $productImageSetsResource
     */
    public function __construct(ProductsProductImageSetsResourceRelationshipToProductImageSetsRestApiInterface $productImageSetsResource)
    {
        $this->productImageSetsResource = $productImageSetsResource;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface[] $resources
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return void
     */
    public function mapResourceRelationships(array $resources, RestRequestInterface $restRequest): void
    {
        foreach ($resources as $resource) {
            $abstractProductImageSetsResource = $this->productImageSetsResource
                ->findConcreteProductImageSetsByConcreteProductId($resource->getId(), $restRequest);
            if ($abstractProductImageSetsResource !== null) {
                $resource->addRelationship($abstractProductImageSetsResource);
            }
        }
    }
}
