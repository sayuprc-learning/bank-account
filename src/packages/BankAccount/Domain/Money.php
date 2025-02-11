<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;
use Shared\DomainSupport\IntegerValueObject;

/**
 * お金を表すクラス
 */
class Money extends IntegerValueObject
{
    /**
     * @throws Exception
     */
    public function __construct(int $value)
    {
        parent::__construct($value);
    }
}
