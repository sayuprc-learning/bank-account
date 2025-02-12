<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Domain;

use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\Balance;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\BankAccountService;
use Exception;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BankAccountServiceTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
    }

    #[Test]
    public function 存在する口座を取得できる(): void
    {
        $accountNumber = new AccountNumber('01234567');

        $this->bankAccountRepository->shouldReceive('find')
            ->with($accountNumber)
            ->andReturn(new BankAccount($accountNumber, new Balance(0)))
            ->once();

        $service = new BankAccountService($this->bankAccountRepository);

        $bankAccount = $service->getBankAccount($accountNumber);

        $this->assertSame('01234567', $bankAccount->accountNumber->value);
        $this->assertSame(0, $bankAccount->balance->value);
    }

    #[Test]
    public function 口座が存在しない場合、例外(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('口座が存在しません: 01234567');

        $accountNumber = new AccountNumber('01234567');

        $this->bankAccountRepository->shouldReceive('find')
            ->with($accountNumber)
            ->andReturnNull()
            ->once();

        $service = new BankAccountService($this->bankAccountRepository);

        $service->getBankAccount($accountNumber);
    }
}
