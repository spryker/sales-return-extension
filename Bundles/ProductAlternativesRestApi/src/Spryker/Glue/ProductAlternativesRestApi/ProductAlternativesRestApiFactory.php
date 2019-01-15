<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\ProductAlternativesRestApi;

use Spryker\Glue\Kernel\AbstractFactory;
use Spryker\Glue\ProductAlternativesRestApi\Dependency\Client\ProductAlternativesRestApiToProductAlternativeStorageClientInterface;
use Spryker\Glue\ProductAlternativesRestApi\Dependency\Client\ProductAlternativesRestApiToProductStorageClientInterface;
use Spryker\Glue\ProductAlternativesRestApi\Dependency\Resource\ProductAlternativesRestApiToProductsRestApiResourceInterface;
use Spryker\Glue\ProductAlternativesRestApi\Processor\AbstractAlternativeProduct\AbstractAlternativeProductReader;
use Spryker\Glue\ProductAlternativesRestApi\Processor\AbstractAlternativeProduct\AbstractAlternativeProductReaderInterface;
use Spryker\Glue\ProductAlternativesRestApi\Processor\ConcreteAlternativeProduct\ConcreteAlternativeProductReader;
use Spryker\Glue\ProductAlternativesRestApi\Processor\ConcreteAlternativeProduct\ConcreteAlternativeProductReaderInterface;
use Spryker\Glue\ProductAlternativesRestApi\Processor\RestResponseBuilder\AlternativeProductRestResponseBuilder;
use Spryker\Glue\ProductAlternativesRestApi\Processor\RestResponseBuilder\AlternativeProductRestResponseBuilderInterface;

class ProductAlternativesRestApiFactory extends AbstractFactory
{
    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Processor\ConcreteAlternativeProduct\ConcreteAlternativeProductReaderInterface
     */
    public function createConcreteAlternativeProductReader(): ConcreteAlternativeProductReaderInterface
    {
        return new ConcreteAlternativeProductReader(
            $this->getProductAlternativeStorageClient(),
            $this->getProductStorageClient(),
            $this->createAlternativeProductRestResponseBuilder()
        );
    }

    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Processor\AbstractAlternativeProduct\AbstractAlternativeProductReaderInterface
     */
    public function createAbstractAlternativeProductReader(): AbstractAlternativeProductReaderInterface
    {
        return new AbstractAlternativeProductReader(
            $this->getProductAlternativeStorageClient(),
            $this->getProductStorageClient(),
            $this->createAlternativeProductRestResponseBuilder()
        );
    }

    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Processor\RestResponseBuilder\AlternativeProductRestResponseBuilderInterface
     */
    public function createAlternativeProductRestResponseBuilder(): AlternativeProductRestResponseBuilderInterface
    {
        return new AlternativeProductRestResponseBuilder(
            $this->getResourceBuilder(),
            $this->getProductsRestApiResource()
        );
    }

    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Dependency\Client\ProductAlternativesRestApiToProductAlternativeStorageClientInterface
     */
    public function getProductAlternativeStorageClient(): ProductAlternativesRestApiToProductAlternativeStorageClientInterface
    {
        return $this->getProvidedDependency(ProductAlternativesRestApiDependencyProvider::CLIENT_PRODUCT_ALTERNATIVE_STORAGE);
    }

    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Dependency\Client\ProductAlternativesRestApiToProductStorageClientInterface
     */
    public function getProductStorageClient(): ProductAlternativesRestApiToProductStorageClientInterface
    {
        return $this->getProvidedDependency(ProductAlternativesRestApiDependencyProvider::CLIENT_PRODUCT_STORAGE);
    }

    /**
     * @return \Spryker\Glue\ProductAlternativesRestApi\Dependency\Resource\ProductAlternativesRestApiToProductsRestApiResourceInterface
     */
    public function getProductsRestApiResource(): ProductAlternativesRestApiToProductsRestApiResourceInterface
    {
        return $this->getProvidedDependency(ProductAlternativesRestApiDependencyProvider::RESOURCE_PRODUCTS_REST_API);
    }
}
