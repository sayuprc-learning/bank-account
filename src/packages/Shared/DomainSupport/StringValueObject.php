<?php

declare(strict_types=1);

namespace Shared\DomainSupport;

/**
 * string の ValueObject を表現するクラス
 */
abstract class StringValueObject
{
    public function __construct(public readonly string $value)
    {
    }
}
