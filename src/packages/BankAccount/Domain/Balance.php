<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;
use Shared\DomainSupport\IntegerValueObject;

/**
 * 口座の残高を表すクラス
 *
 * 今回のシステムではマイナスの値にならないので、マイナス値は許容していない
 */
class Balance extends IntegerValueObject
{
    /**
     * @throws Exception
     */
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new Exception('残高は 0 以上でなければいけません');
        }

        parent::__construct($value);
    }

    /**
     * @throws Exception
     */
    public function add(Money $other): self
    {
        if ($other->value < 0) {
            throw new Exception('金額は 0 以上でなければいけません');
        }

        return new Balance($this->value + $other->value);
    }

    /**
     * @throws Exception
     */
    public function subtract(Money $other): self
    {
        if ($this->value < $other->value) {
            throw new Exception('残高不足です');
        }

        return new Balance($this->value - $other->value);
    }
}
