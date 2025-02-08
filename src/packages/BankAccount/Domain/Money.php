<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;
use Shared\DomainSupport\IntegerValueObject;

class Money extends IntegerValueObject
{
    /**
     * @throws Exception
     */
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new Exception('金額は 0 以上でなければいけません');
        }

        parent::__construct($value);
    }

    /**
     * @throws Exception
     */
    public function add(Money $other): self
    {
        return new Money($this->value + $other->value);
    }

    /**
     * @throws Exception
     */
    public function subtract(Money $other): self
    {
        if ($this->value < $other->value) {
            throw new Exception('残高不足です');
        }

        return new Money($this->value - $other->value);
    }
}
