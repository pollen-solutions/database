<?php

declare(strict_types=1);

namespace Pollen\Database;

/**
 * @mixin \Illuminate\Database\Capsule\Manager
 */
interface DatabaseManagerInterface
{
    /**
     * Sets default connection from environment variables.
     *
     * @return static
     */
    public function withDefaultEnvConnection(): DatabaseManagerInterface;
}