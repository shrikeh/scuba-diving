<?php

declare(strict_types=1);

namespace App\Kit\Model\Traits;

use App\Kit\Model\ModelInterface;

trait PromiseResolveTrait
{
    /**
     * @var ModelInterface
     */
    private ?ModelInterface $model;

    /**
     * @var callable
     */
    private $resolver;

    /**
     * @return ModelInterface
     */
    private function resolveModel(): ModelInterface
    {
        if (!isset($this->model)) {
            $resolver = $this->resolver;
            $this->model = $resolver();
        }

        return $this->model;
    }
}
