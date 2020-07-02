<?php

namespace Tests\Codecept\Module;

use App\Kernel\DefaultKernel;
use Codeception\Exception\ModuleRequireException;
use Codeception\Module\Symfony as CodeCeptSymfonyModule;

final class Symfony extends CodeCeptSymfonyModule
{
    /**
     * @throws ModuleRequireException
     * We don't get to choose the name of this, sadly.
     * @phpcs:disable PSR2.Methods.MethodDeclaration.Underscore
     */
    public function _initialize()
    {
        if (!is_a($this->getKernelClass(), DefaultKernel::class, true)) {
            return parent::_initialize();
        }

        $this->initialiseSymfony();
    }

    /**
     * @throws ModuleRequireException
     */
    private function initialiseSymfony(): void
    {
        $this->kernelClass = $this->getKernelClass();
        $maxNestingLevel = 200; // Symfony may have very long nesting level
        $xdebugMaxLevelKey = 'xdebug.max_nesting_level';
        if (ini_get($xdebugMaxLevelKey) < $maxNestingLevel) {
            ini_set($xdebugMaxLevelKey, $maxNestingLevel);
        }

        $this->kernel = DefaultKernel::fromArray($_SERVER);
        $this->kernel->boot();

        if ($this->config['cache_router'] === true) {
            $this->persistService('router', true);
        }
    }
}
