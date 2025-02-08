<?php

declare(strict_types=1);

namespace Tests\Feature\BankAccount\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Shared\Route\Api\V1\RouteMap;
use Tests\TestCase;

class WithdrawTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function 引き落としができる(): void
    {
        DB::table('bank_accounts')->insert([
            'account_number' => '00000000',
            'balance' => 1000,
        ]);

        $this->post(route(RouteMap::Withdraw), [
            'account_number' => '00000000',
            'amount' => 100,
        ])->assertStatus(200)
            ->assertJson([
                'account_number' => '00000000',
                'amount' => 100,
                'balance' => 900,
            ]);
    }
}
