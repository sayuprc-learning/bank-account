<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Applications\CreateAccount;

use BankAccount\Applications\CreateAccount\CreateAccountInteractor;
use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use Exception;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Shared\DebugTransaction\NopTransaction;
use Shared\Transaction\TransactionInterface;
use Tests\TestCase;

class CreateAccountInteractorTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(TransactionInterface::class, NopTransaction::class);
        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
    }

    #[Test]
    public function 口座作成に成功する場合(): void
    {
        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturnNull()
            ->once();

        $this->bankAccountRepository->shouldReceive('save')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof BankAccount
                    && $arg->accountNumber->value === '00000000'
                    && $arg->balance->value === 0;
            }))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new CreateAccountInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new CreateAccountRequest('00000000', 0);
        $interactor->handle($request);
    }

    #[Test]
    public function 入金額が0未満の場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('入金額は 0 以上である必要があります');

        $this->bankAccountRepository->shouldNotReceive('find');
        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new CreateAccountInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new CreateAccountRequest('00000000', -1);
        $interactor->handle($request);
    }

    #[Test]
    public function 口座番号がすでに存在する場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('指定の口座番号は使えません');

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Money(1)))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new CreateAccountInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new CreateAccountRequest('00000000', 0);
        $interactor->handle($request);
    }
}
