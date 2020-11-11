<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductOfferMerchantPortalGui\Communication;

use Generated\Shared\Transfer\ProductOfferTransfer;
use Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Builder\ProductNameBuilder;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Builder\ProductNameBuilderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\GuiTableConfigurationProviderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\ProductGuiTableConfigurationProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\ProductOfferGuiTableConfigurationProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\ProductOfferPriceGuiTableConfigurationProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\ProductOfferPriceGuiTableConfigurationProviderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\OffersDashboardCardProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\OffersDashboardCardProviderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\ProductGuiTableDataProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\ProductOfferGuiTableDataProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\ProductOfferPriceGuiTableDataProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Expander\MerchantOrderItemTableExpander;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Expander\MerchantOrderItemTableExpanderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferCreateFormDataProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferCreateFormDataProviderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferUpdateFormDataProvider;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferUpdateFormDataProviderInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\ProductOfferForm;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\Transformer\ProductOfferStockTransformer;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\Transformer\QuantityTransformer;
use Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\Transformer\StoresTransformer;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToCurrencyFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToLocaleFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToMerchantStockFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToMerchantUserFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToPriceProductFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToProductFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToProductOfferFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToRouterFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToStoreFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToTranslatorFacadeInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Service\ProductOfferMerchantPortalGuiToUtilEncodingServiceInterface;
use Spryker\Zed\ProductOfferMerchantPortalGui\ProductOfferMerchantPortalGuiDependencyProvider;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormInterface;
use Twig\Environment;

/**
 * @method \Spryker\Zed\ProductOfferMerchantPortalGui\Persistence\ProductOfferMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductOfferMerchantPortalGui\ProductOfferMerchantPortalGuiConfig getConfig()
 */
class ProductOfferMerchantPortalGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\GuiTableConfigurationProviderInterface
     */
    public function createProductGuiTableConfigurationProvider(): GuiTableConfigurationProviderInterface
    {
        return new ProductGuiTableConfigurationProvider(
            $this->getTranslatorFacade(),
            $this->getGuiTableFactory()
        );
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\GuiTableConfigurationProviderInterface
     */
    public function createProductOfferGuiTableConfigurationProvider(): GuiTableConfigurationProviderInterface
    {
        return new ProductOfferGuiTableConfigurationProvider(
            $this->getStoreFacade(),
            $this->getTranslatorFacade(),
            $this->getGuiTableFactory()
        );
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\ConfigurationProvider\ProductOfferPriceGuiTableConfigurationProviderInterface
     */
    public function createProductOfferPriceGuiTableConfigurationProvider(): ProductOfferPriceGuiTableConfigurationProviderInterface
    {
        return new ProductOfferPriceGuiTableConfigurationProvider(
            $this->getGuiTableFactory(),
            $this->getPriceProductFacade(),
            $this->getStoreFacade(),
            $this->getCurrencyFacade()
        );
    }

    /**
     * @return \Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface
     */
    public function createProductTableDataProvider(): GuiTableDataProviderInterface
    {
        return new ProductGuiTableDataProvider(
            $this->getRepository(),
            $this->getTranslatorFacade(),
            $this->createProductNameBuilder(),
            $this->getMerchantUserFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @return \Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface
     */
    public function createProductOfferTableDataProvider(): GuiTableDataProviderInterface
    {
        return new ProductOfferGuiTableDataProvider(
            $this->getRepository(),
            $this->getTranslatorFacade(),
            $this->createProductNameBuilder(),
            $this->getMerchantUserFacade(),
            $this->getLocaleFacade()
        );
    }

    /**
     * @param int $idProductOffer
     *
     * @return \Spryker\Shared\GuiTable\DataProvider\GuiTableDataProviderInterface
     */
    public function createProductOfferPriceTableDataProvider(int $idProductOffer): GuiTableDataProviderInterface
    {
        return new ProductOfferPriceGuiTableDataProvider(
            $idProductOffer,
            $this->getRepository()
        );
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Builder\ProductNameBuilderInterface
     */
    public function createProductNameBuilder(): ProductNameBuilderInterface
    {
        return new ProductNameBuilder();
    }

    /**
     * @param \Generated\Shared\Transfer\ProductOfferTransfer|null $data
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createProductOfferForm(?ProductOfferTransfer $data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(ProductOfferForm::class, $data, $options);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferCreateFormDataProviderInterface
     */
    public function createProductOfferCreateFormDataProvider(): ProductOfferCreateFormDataProviderInterface
    {
        return new ProductOfferCreateFormDataProvider(
            $this->getProductFacade(),
            $this->getMerchantUserFacade(),
            $this->getMerchantStockFacade()
        );
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Form\DataProvider\ProductOfferUpdateFormDataProviderInterface
     */
    public function createProductOfferUpdateFormDataProvider(): ProductOfferUpdateFormDataProviderInterface
    {
        return new ProductOfferUpdateFormDataProvider(
            $this->getProductFacade(),
            $this->getProductOfferFacade(),
            $this->getMerchantStockFacade(),
            $this->getMerchantUserFacade()
        );
    }

    /**
     * @return \Symfony\Component\Form\DataTransformerInterface
     */
    public function createStoresTransformer(): DataTransformerInterface
    {
        return new StoresTransformer();
    }

    /**
     * @return \Symfony\Component\Form\DataTransformerInterface
     */
    public function createQuantityTransformer(): DataTransformerInterface
    {
        return new QuantityTransformer();
    }

    /**
     * @return \Symfony\Component\Form\DataTransformerInterface
     */
    public function createProductOfferStockTransformer(): DataTransformerInterface
    {
        return new ProductOfferStockTransformer();
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\DataProvider\OffersDashboardCardProviderInterface
     */
    public function createOffersDashboardCardProvider(): OffersDashboardCardProviderInterface
    {
        return new OffersDashboardCardProvider(
            $this->getRepository(),
            $this->getMerchantUserFacade(),
            $this->getRouterFacade(),
            $this->getConfig(),
            $this->getTwigEnvironment()
        );
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Communication\Expander\MerchantOrderItemTableExpanderInterface
     */
    public function createMerchantOrderItemTableExpander(): MerchantOrderItemTableExpanderInterface
    {
        return new MerchantOrderItemTableExpander($this->getProductOfferFacade());
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToLocaleFacadeInterface
     */
    public function getLocaleFacade(): ProductOfferMerchantPortalGuiToLocaleFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Service\ProductOfferMerchantPortalGuiToUtilEncodingServiceInterface
     */
    public function getUtilEncodingService(): ProductOfferMerchantPortalGuiToUtilEncodingServiceInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToMerchantUserFacadeInterface
     */
    public function getMerchantUserFacade(): ProductOfferMerchantPortalGuiToMerchantUserFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_MERCHANT_USER);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToTranslatorFacadeInterface
     */
    public function getTranslatorFacade(): ProductOfferMerchantPortalGuiToTranslatorFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_TRANSLATOR);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToStoreFacadeInterface
     */
    public function getStoreFacade(): ProductOfferMerchantPortalGuiToStoreFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToRouterFacadeInterface
     */
    public function getRouterFacade(): ProductOfferMerchantPortalGuiToRouterFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_ROUTER);
    }

    /**
     * @return \Twig\Environment
     */
    protected function getTwigEnvironment(): Environment
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::SERVICE_TWIG);
    }

    /**
     * @return \Spryker\Shared\GuiTable\Http\GuiTableDataRequestExecutorInterface
     */
    public function getGuiTableHttpDataRequestExecutor(): GuiTableDataRequestExecutorInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_HTTP_DATA_REQUEST_EXECUTOR);
    }

    /**
     * @return \Spryker\Shared\GuiTable\GuiTableFactoryInterface
     */
    public function getGuiTableFactory(): GuiTableFactoryInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::SERVICE_GUI_TABLE_FACTORY);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToProductFacadeInterface
     */
    public function getProductFacade(): ProductOfferMerchantPortalGuiToProductFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_PRODUCT);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToProductOfferFacadeInterface
     */
    public function getProductOfferFacade(): ProductOfferMerchantPortalGuiToProductOfferFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_PRODUCT_OFFER);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToMerchantStockFacadeInterface
     */
    public function getMerchantStockFacade(): ProductOfferMerchantPortalGuiToMerchantStockFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_MERCHANT_STOCK);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToCurrencyFacadeInterface
     */
    public function getCurrencyFacade(): ProductOfferMerchantPortalGuiToCurrencyFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_CURRENCY);
    }

    /**
     * @return \Spryker\Zed\ProductOfferMerchantPortalGui\Dependency\Facade\ProductOfferMerchantPortalGuiToPriceProductFacadeInterface
     */
    public function getPriceProductFacade(): ProductOfferMerchantPortalGuiToPriceProductFacadeInterface
    {
        return $this->getProvidedDependency(ProductOfferMerchantPortalGuiDependencyProvider::FACADE_PRICE_PRODUCT);
    }
}
