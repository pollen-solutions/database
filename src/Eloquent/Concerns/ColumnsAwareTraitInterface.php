<?php

declare(strict_types=1);

namespace Pollen\Database\Eloquent\Concerns;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
interface ColumnsAwareTraitInterface
{
    /**
     * Retrieve the list of column for the table.
     *
     * @return string[]|array
     */
    public function getColumns(): array;

    /**
     * Check if column exists by its name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasColumn(string $name): bool;
}