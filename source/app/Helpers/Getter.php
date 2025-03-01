<?php

declare(strict_types=1);

namespace App\Helpers;

/**
 * This trait implements read-only access to a class private properties
 *
 * Example:
 *   $class->property
 *
 * Note:
 *   Please use PHPDoc @property-read $readOnlyProperty annotation
 *   to enable IDE support
 */
trait Getter
{
    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->{$name};
    }
}
