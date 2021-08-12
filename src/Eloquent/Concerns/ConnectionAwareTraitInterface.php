<?php

declare(strict_types=1);

namespace Pollen\Database\Eloquent\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Model
 * @mixin Builder
 */
interface ConnectionAwareTraitInterface
{
    /**
     * Get the database tables prefix.
     *
     * @return string
     */
    public function getTablePrefix(): string;
}