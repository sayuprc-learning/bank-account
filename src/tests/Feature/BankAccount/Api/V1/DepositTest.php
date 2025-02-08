<?php

declare(strict_types=1);

namespace Tests\Feature\BankAccount\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Shared\Route\Api\V1\RouteMap;
use Tests\TestCase;

class DepositTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function 入金ができる(): void
    {
        DB::table('bank_accounts')->insert([
            'account_number' => '00000000',
            'balance' => 0,
        ]);

        $this->post(route(RouteMap::Deposit), [
            'account_number' => '00000000',
            'amount' => 100000,
        ])->assertStatus(200)
            ->assertJson([
                'account_number' => '00000000',
                'balance' => 100000,
            ]);
    }
}
