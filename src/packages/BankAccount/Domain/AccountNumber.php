<?php

declare(strict_types=1);

namespace BankAccount\Domain;

use Exception;
use Shared\DomainSupport\StringValueObject;

class AccountNumber extends StringValueObject
{
    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        if (! preg_match('/\A\d{8}\z/', $value)) {
            throw new Exception('口座番号は 8 桁で入力してください');
        }

        parent::__construct($value);
    }
}
