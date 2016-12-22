<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Setup\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Messenger\Business\Model\MessengerInterface;
use Spryker\Zed\Setup\Business\Internal\Install;
use Spryker\Zed\Setup\Business\Model\Cronjobs;
use Spryker\Zed\Setup\Business\Model\DirectoryRemover;
use Spryker\Zed\Setup\Communication\Console\DeployPreparePropelConsole;
use Spryker\Zed\Setup\Communication\Console\GenerateClientIdeAutoCompletionConsole;
use Spryker\Zed\Setup\Communication\Console\GenerateIdeAutoCompletionConsole;
use Spryker\Zed\Setup\Communication\Console\GenerateServiceIdeAutoCompletionConsole;
use Spryker\Zed\Setup\Communication\Console\GenerateZedIdeAutoCompletionConsole;
use Spryker\Zed\Setup\Communication\Console\InstallConsole;
use Spryker\Zed\Setup\Communication\Console\JenkinsDisableConsole;
use Spryker\Zed\Setup\Communication\Console\JenkinsEnableConsole;
use Spryker\Zed\Setup\Communication\Console\JenkinsGenerateConsole;
use Spryker\Zed\Setup\Communication\Console\Npm\RunnerConsole;
use Spryker\Zed\Setup\Communication\Console\RemoveGeneratedDirectoryConsole;
use Spryker\Zed\Setup\SetupDependencyProvider;

/**
 * @method \Spryker\Zed\Setup\SetupConfig getConfig()
 */
class SetupBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \Spryker\Zed\Setup\Business\Model\Cronjobs
     */
    public function createModelCronjobs()
    {
        $config = $this->getConfig();

        return new Cronjobs($config);
    }

    /**
     * @return \Spryker\Zed\Setup\Business\Model\DirectoryRemoverInterface
     */
    public function createModelGeneratedDirectoryRemover()
    {
        return $this->createDirectoryRemover(
            $this->getConfig()->getGeneratedDirectory()
        );
    }

    /**
     * @param string $path
     *
     * @return \Spryker\Zed\Setup\Business\Model\DirectoryRemoverInterface
     */
    protected function createDirectoryRemover($path)
    {
        return new DirectoryRemover($path);
    }

    /**
     * @return \Spryker\Zed\ZedRequest\Communication\Plugin\TransferObject\Repeater
     */
    public function getTransferObjectRepeater()
    {
        return $this->getProvidedDependency(SetupDependencyProvider::PLUGIN_TRANSFER_OBJECT_REPEATER);
    }

    /**
     * @deprecated Hook in commands manually on project level
     *
     * @return \Symfony\Component\Console\Command\Command[]
     */
    public function getConsoleCommands()
    {
        return [
            $this->createGenerateIdeAutoCompletionConsole(),
            $this->createGenerateZedIdeAutoCompletionConsole(),
            $this->createGenerateClientIdeAutoCompletionConsole(),
            $this->createGenerateServiceIdeAutoCompletionConsole(),
            $this->createRunnerConsole(),
            $this->createRemoveGeneratedDirectoryConsole(),
            $this->createInstallConsole(),
            $this->createJenkinsEnableConsole(),
            $this->createJenkinsDisableConsole(),
            $this->createJenkinsGenerateConsole(),
            $this->createDeployPreparePropelConsole(),
        ];
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\GenerateIdeAutoCompletionConsole
     */
    protected function createGenerateIdeAutoCompletionConsole()
    {
        return new GenerateIdeAutoCompletionConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\GenerateZedIdeAutoCompletionConsole
     */
    protected function createGenerateZedIdeAutoCompletionConsole()
    {
        return new GenerateZedIdeAutoCompletionConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\GenerateClientIdeAutoCompletionConsole
     */
    protected function createGenerateClientIdeAutoCompletionConsole()
    {
        return new GenerateClientIdeAutoCompletionConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\GenerateServiceIdeAutoCompletionConsole
     */
    protected function createGenerateServiceIdeAutoCompletionConsole()
    {
        return new GenerateServiceIdeAutoCompletionConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\Npm\RunnerConsole
     */
    protected function createRunnerConsole()
    {
        return new RunnerConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\RemoveGeneratedDirectoryConsole
     */
    protected function createRemoveGeneratedDirectoryConsole()
    {
        return new RemoveGeneratedDirectoryConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\InstallConsole
     */
    protected function createInstallConsole()
    {
        return new InstallConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\JenkinsEnableConsole
     */
    protected function createJenkinsEnableConsole()
    {
        return new JenkinsEnableConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\JenkinsDisableConsole
     */
    protected function createJenkinsDisableConsole()
    {
        return new JenkinsDisableConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\JenkinsGenerateConsole
     */
    protected function createJenkinsGenerateConsole()
    {
        return new JenkinsGenerateConsole();
    }

    /**
     * @deprecated Will be removed with next major release
     *
     * @return \Spryker\Zed\Setup\Communication\Console\DeployPreparePropelConsole
     */
    protected function createDeployPreparePropelConsole()
    {
        return new DeployPreparePropelConsole();
    }

    /**
     * @param \Spryker\Zed\Messenger\Business\Model\MessengerInterface $messenger
     *
     * @return \Spryker\Zed\Product\Business\Internal\Install
     */
    public function createTestDataInstaller(MessengerInterface $messenger)
    {
        $installer = new Install();
        $installer->setMessenger($messenger);

        return $installer;
    }

}
