<?php

declare(strict_types=1);

namespace Tests\Unit\BankAccount\Applications\CreateAccount;

use BankAccount\Applications\CreateAccount\CreateAccountInteractor;
use BankAccount\Domain\AccountNumber;
use BankAccount\Domain\Balance;
use BankAccount\Domain\BankAccount;
use BankAccount\Domain\BankAccountRepositoryInterface;
use BankAccount\UseCases\CreateAccount\CreateAccountRequest;
use Exception;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Shared\DebugTransaction\NopTransaction;
use Shared\Random\RandomGeneratorInterface;
use Shared\Transaction\TransactionInterface;
use Tests\TestCase;

class CreateAccountInteractorTest extends TestCase
{
    private BankAccountRepositoryInterface&MockInterface $bankAccountRepository;

    private MockInterface&RandomGeneratorInterface $generator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(TransactionInterface::class, NopTransaction::class);
        $this->bankAccountRepository = Mockery::mock(BankAccountRepositoryInterface::class);
        $this->generator = Mockery::mock(RandomGeneratorInterface::class);
    }

    #[Test]
    public function 口座作成に成功する場合(): void
    {
        $this->generator->shouldReceive('generate')
            ->with(8)
            ->andReturn('00000000')
            ->once();

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

        $interactor = new CreateAccountInteractor(
            $this->app->make(TransactionInterface::class),
            $this->bankAccountRepository,
            $this->generator,
        );

        $request = new CreateAccountRequest(0);
        $response = $interactor->handle($request);

        $this->assertSame('00000000', $response->accountNumber);
        $this->assertSame(0, $response->balance);
    }

    #[Test]
    public function 入金額が0未満の場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('入金額は 0 以上である必要があります');

        $this->generator->shouldNotReceive('generate');
        $this->bankAccountRepository->shouldNotReceive('find');
        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new CreateAccountInteractor(
            $this->app->make(TransactionInterface::class),
            $this->bankAccountRepository,
            $this->generator,
        );

        $request = new CreateAccountRequest(-1);
        $interactor->handle($request);
    }

    #[Test]
    public function 口座番号がすでに存在する場合_例外が投げられる(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('指定の口座番号は使えません');

        $this->generator->shouldNotReceive('generate')
            ->with(8)
            ->andReturn('00000000')
            ->once();

        $this->bankAccountRepository->shouldReceive('find')
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof AccountNumber
                    && $arg->value === '00000000';
            }))
            ->andReturn(new BankAccount(new AccountNumber('00000000'), new Balance(1)))
            ->once();

        $this->bankAccountRepository->shouldNotReceive('save');
        $this->bankAccountRepository->shouldNotReceive('all');

        $interactor = new CreateAccountInteractor(
            $this->app->make(TransactionInterface::class),
            $this->bankAccountRepository,
            $this->generator,
        );

        $request = new CreateAccountRequest(0);
        $interactor->handle($request);
    }
}
