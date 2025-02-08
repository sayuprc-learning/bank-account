<?php

declare(strict_types=1);

namespace Tests\Feature\BankAccount\Api\V1;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Shared\Route\Api\V1\RouteMap;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use DatabaseTransactions;

    #[Test]
    public function 口座振込ができる(): void
    {
        DB::table('bank_accounts')->insert([
            [
                'account_number' => '00000000',
                'balance' => 100,
            ],
            [
                'account_number' => '11111111',
                'balance' => 300,
            ],
        ]);

        $this->post(route(RouteMap::Transfer), [
            'from_account_number' => '11111111',
            'to_account_number' => '00000000',
            'amount' => 50,
        ])->assertStatus(200)
            ->assertJson([
                'from_account_number' => '11111111',
                'to_account_number' => '00000000',
                'amount' => 50,
                'balance' => 250,
            ]);
    }
}
