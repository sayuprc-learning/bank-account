<?php

declare(strict_types=1);

namespace Shared\DomainSupport;

/**
 * int の ValueObject を表現するクラス
 */
abstract class IntegerValueObject
{
    public function __construct(public readonly int $value)
    {
    }
}
