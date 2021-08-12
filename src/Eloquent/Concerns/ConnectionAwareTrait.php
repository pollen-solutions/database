<?php

declare(strict_types=1);

namespace Pollen\Database\Eloquent\Concerns;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @see \Pollen\Database\Eloquent\Concerns\ConnectionAwareTraitInterface
 */
trait ConnectionAwareTrait
{
    /**
     * Get the database tables prefix.
     *
     * @return string
     */
    public function getTablePrefix(): string
    {
        return $this->getConnection()->getTablePrefix();
    }
}