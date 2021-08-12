<?php

declare(strict_types=1);

namespace Pollen\Database\Eloquent\Concerns;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @see \Pollen\Database\Eloquent\Concerns\ColumnsAwareTraitInterface
 */
trait ColumnsAwareTrait
{
    /**
     * List of columns.
     * @var string[]
     */
    protected array $columns;

    /**
     * Retrieve the list of column for the table.
     *
     * @return string[]|array
     */
    public function getColumns(): array
    {
        if (is_null($this->columns)) {
            $this->columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable())
                ?: [];
        }

        return $this->columns;
    }

    /**
     * Check if column exists by its name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasColumn(string $name): bool
    {
        return in_array($name, $this->getColumns(), true);
    }
}