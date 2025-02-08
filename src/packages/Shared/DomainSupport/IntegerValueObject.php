<?php

declare(strict_types=1);

namespace Shared\DomainSupport;

abstract class IntegerValueObject
{
    public function __construct(public readonly int $value)
    {
    }
}
