<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Applications\Transfer;

use BankAccount\Applications\Transfer\TransferInteractor;
use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\Domain\Money;
use BankAccount\UseCases\Transfer\TransferRequest;
use Exception;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Shared\DebugTransaction\NopTransaction;
use Shared\Transaction\TransactionInterface;
use Tests\TestCase;

class TransferInteractorTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(TransactionInterface::class, NopTransaction::class);
        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
    }

    #[Test]
    public function 振込に成功する場合(): void
    {
        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Money(1)))
            ->once();

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '99999999';
            }))
            ->andReturn(new BankAccount(new AccountNumber('99999999'), new Money(0)))
            ->once();

        $this->bankAccountRepository->shouldReceive('save')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof BankAccount
                    && $arg->accountNumber->value === '00000000'
                    && $arg->balance->value === 0;
            }))
            ->once();

        $this->bankAccountRepository->shouldReceive('save')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof BankAccount
                    && $arg->accountNumber->value === '99999999'
                    && $arg->balance->value === 1;
            }))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '99999999', 1);
        $response = $interactor->handle($request);

        $this->assertSame('00000000', $response->fromAccountNumber);
        $this->assertSame('99999999', $response->toAccountNumber);
        $this->assertSame(1, $response->amount);
        $this->assertSame(0, $response->balance);
    }

    #[Test]
    public function 振込額が1未満の場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('振込額は 1 以上の必要があります');

        $this->bankAccountRepository->shouldNotReceive('find');
        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '99999999', 0);
        $interactor->handle($request);
    }

    #[Test]
    public function 振込元と振込先が同じ場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('振込元口座と振込先口座を同じにすることはできません');

        $this->bankAccountRepository->shouldNotReceive('find');
        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '00000000', 1);
        $interactor->handle($request);
    }

    #[Test]
    public function 振込元口座が見つからない場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('振込元口座が見つかりませんでした');

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturnNull()
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '99999999', 1);
        $interactor->handle($request);
    }

    #[Test]
    public function 振込先口座が見つからない場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('振込先口座が見つかりませんでした');

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Money(1)))
            ->once();

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '99999999';
            }))
            ->andReturnNull()
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '99999999', 1);
        $interactor->handle($request);
    }

    #[Test]
    public function 残高が足りなかった場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('残高不足です');

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Money(0)))
            ->once();

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '99999999';
            }))
            ->andReturn(new BankAccount(new AccountNumber('99999999'), new Money(0)))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new TransferInteractor($this->app->make(TransactionInterface::class), $this->bankAccountRepository);

        $request = new TransferRequest('00000000', '99999999', 1);
        $interactor->handle($request);
    }
}
