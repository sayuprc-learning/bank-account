<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Applications\List;

use BankAccount\Applications\List\ListInteractor;
use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\Balance;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListInteractorTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
    }

    #[Test]
    public function 件数が0の場合(): void
    {
        $this->bankAccountRepository->shouldReceive('all')
            ->andReturn([])
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');

        $interactor = new ListInteractor($this->bankAccountRepository);

        $response = $interactor->handle();

        $this->assertCount(0, $response->bankAccounts);
    }

    #[Test]
    public function 件数が複数件の場合(): void
    {
        $bankAccount1 = new BankAccount(
            new AccountNumber('00000000'),
            new Balance(100),
        );

        $bankAccount2 = new BankAccount(
            new AccountNumber('99999999'),
            new Balance(10000),
        );

        $this->bankAccountRepository->shouldReceive('all')
            ->andReturn([$bankAccount1, $bankAccount2])
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');

        $interactor = new ListInteractor($this->bankAccountRepository);

        $response = $interactor->handle();

        $this->assertCount(2, $response->bankAccounts);
    }
}
