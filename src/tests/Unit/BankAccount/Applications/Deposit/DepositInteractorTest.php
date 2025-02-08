<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Applications\Deposit;

use BankAccount\Applications\Deposit\DepositInteractor;
use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Deposit\DepositRequest;
use Exception;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Shared\DebugTransaction\NopTransaction;
use Shared\Transaction\TransactionInterface;
use Tests\TestCase;

class DepositInteractorTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(TransactionInterface::class, NopTransaction::class);
        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
    }

    #[Test]
    public function 入金に成功する場合(): void
    {
        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Money(0)))
            ->once();

        $this->bankAccountRepository->shouldReceive('save')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof BankAccount
                    && $arg->accountNumber->value === '00000000'
                    && $arg->balance->value === 1;
            }))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new DepositInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new DepositRequest('00000000', 1);
        $response = $interactor->handle($request);

        $this->assertSame('00000000', $response->accountNumber);
        $this->assertSame(1, $response->balance);
    }

    #[Test]
    public function 入金額が1未満の場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('入金額は 1 以上の必要があります');

        $this->bankAccountRepository->shouldNotReceive('find');
        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new DepositInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new DepositRequest('00000000', 0);
        $interactor->handle($request);
    }

    #[Test]
    public function 入金先口座が見つからない場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('入金先口座が見つかりませんでした');

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturnNull()
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new DepositInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new DepositRequest('00000000', 1);
        $interactor->handle($request);
    }
}
